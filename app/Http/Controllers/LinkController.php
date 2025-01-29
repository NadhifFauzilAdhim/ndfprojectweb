<?php

namespace App\Http\Controllers;

use App\Models\BlockedIp;
use App\Models\Link;
use App\Models\Linkvisithistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use RealRashid\SweetAlert\Facades\Alert;


class LinkController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Cache totals for 5 minutes
        $totals = Cache::remember("user_{$userId}_totals", 300, function () use ($userId) {
            return Link::where('user_id', $userId)
                ->selectRaw('COUNT(*) as total_links, SUM(visits) as total_visits, SUM(unique_visits) as total_unique_visits')
                ->first();
        });

        $totalLinks = (int)$totals->total_links;
        $totalVisit = (int)$totals->total_visits;
        $totalUniqueVisit = (int)$totals->total_unique_visits;

        $search = $request->input('search');

        $links = Link::where('user_id', $userId)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('slug', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(6);

        $sevenDaysAgo = Carbon::now()->subDays(7);

        // Cache topLinks for 5 minutes
        $topLinks = Cache::remember("user_{$userId}_topLinks", 300, function () use ($userId, $sevenDaysAgo) {
            return Link::where('user_id', $userId)
                ->orderByDesc('visits')
                ->take(5)
                ->with(['visithistory' => function ($query) use ($sevenDaysAgo) {
                    $query->where('created_at', '>=', $sevenDaysAgo);
                }])
                ->get()
                ->each(function ($link) {
                    $link->visits_last_7_days = $link->visithistory->count();
                });
        });

        $visitData = $this->getAllVisitData($userId);
        if(session()->has('success')) {
            Alert::success('Success', "test");
        }

        return view('dashboard.shortlink.index', compact(
            'totalLinks',
            'totalVisit',
            'totalUniqueVisit',
            'links',
            'topLinks',
            'visitData'
        ))->with('title', 'Short Link');
    }

    /**
     * Show the details of a specific link.
     */
    public function show(Link $link, Request $request)
    {
        $this->authorizeLink($link);

        $filter = $request->query('filter', 'all');
        $visithistory = $this->getVisitHistory($link->id, $filter);

        $redirectedCount = $this->getVisitCount($link->id, 1);
        $rejectedCount = $this->getVisitCount($link->id, 0);

        $blockedIps = BlockedIp::where('link_id', $link->id)->get();

        $topReferersRaw = Linkvisithistory::where('link_id', $link->id)
            ->select('referer_url', DB::raw('COUNT(*) as visit_count'))
            ->groupBy('referer_url')
            ->orderByDesc('visit_count')
            ->limit(5)
            ->get();

        $topReferers = [
            'labels' => $topReferersRaw->pluck('referer_url')->toArray(),
            'data' => $topReferersRaw->pluck('visit_count')->toArray(),
        ];
        
        $chartData = $this->getSingleLinkStatistic($link->id, false);
        $location = $this->getLocationStatistic($link->id);
        return view('dashboard.shortlink.linkdetail', compact(
            'link',
            'visithistory',
            'redirectedCount',
            'rejectedCount',
            'blockedIps',
            'filter',
            'chartData',
            'topReferers',
            'location'
        ))->with('title', 'Detail Link');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
        $this->authorizeLink($link);

        $validatedData = $request->validate([
            'title' => 'nullable|max:255',
            'target_url' => 'required|max:255|url',
            'slug' => 'nullable|max:255|unique:links,slug,' . $link->id,
            'password' => 'nullable|min:6|max:255',
        ]);

        if ($request->has('quickedit')) {
            $validatedData['target_url'] = filter_var($validatedData['target_url'], FILTER_SANITIZE_URL);
            $validatedData['active'] = $request->has('active') ? 1 : 0;

            if ($link->target_url !== $validatedData['target_url']) {
                $websiteTitle = $this->fetchWebsiteTitle($validatedData['target_url']);
                $validatedData['title'] = $websiteTitle ?? null;
            }

            $link->update($validatedData);

            return redirect()->back()->with('success', 'Link updated successfully!');
        }

        $oldSlug = $link->slug;
        $validatedData['target_url'] = filter_var($validatedData['target_url'], FILTER_SANITIZE_URL);
        $validatedData['password_protected'] = $request->has('password_protected') ? 1 : 0;
        $validatedData['password'] = $validatedData['password_protected']
            ? bcrypt($request->input('password', $link->password))
            : null;
        $validatedData['active'] = $request->has('active') ? 1 : 0;

        if ($link->target_url !== $validatedData['target_url'] && !$validatedData['title']) {
            $websiteTitle = $this->fetchWebsiteTitle($validatedData['target_url']);
            $validatedData['title'] = $websiteTitle ?? null;
        }

        $link->update($validatedData);

        return $oldSlug !== $link->slug
            ? response()->json([
                'success' => true,
                'message' => 'Slug updated successfully! Link updated.',
                'redirect' => route('link.show', ['link' => $link->slug]),
            ])
            : response()->json(['success' => true, 'message' => 'Link updated successfully!']);
    }

    public function updateTitle(Request $request, Link $link)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
        ]);

        $link->update(['title' => $validated['title']]);

        return response()->json(['success' => true, 'message' => 'Title updated successfully!']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'target_url' => 'required|max:255|url',
            'slug' => 'required|max:255|unique:links|regex:/^[\S]+$/',
        ]);

        $validatedData['target_url'] = filter_var($validatedData['target_url'], FILTER_SANITIZE_URL);
        $validatedData['user_id'] = Auth::id();

        $websiteTitle = $this->fetchWebsiteTitle($validatedData['target_url']);
        $validatedData['title'] = $websiteTitle ?? null;

        Link::create($validatedData);
        return redirect()->back()->with('success', 'Link Berhasil Ditambahkan');
    }

    private function fetchWebsiteTitle($url)
    {
        try {
            $response = Http::get($url);
            if ($response->successful()) {
                $htmlContent = $response->body();
                $doc = new \DOMDocument();
                @$doc->loadHTML($htmlContent);
                $titleNodes = $doc->getElementsByTagName('title');

                return $titleNodes->length > 0 ? $titleNodes->item(0)->nodeValue : null;
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $this->authorizeLink($link);
        $link->delete();
        return redirect()->back()->with('success', 'Link Berhasil Dihapus');
    }

    /**
     * Get visit data by day.
     */
    private function getSingleLinkStatistic($identifier, $isUser = true)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        $query = Linkvisithistory::when($isUser, fn($q) => $q->whereHas('link', fn($q) => $q->where('user_id', $identifier)))
            ->when(!$isUser, fn($q) => $q->where('link_id', $identifier))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYOFWEEK(created_at) as day'), DB::raw('COUNT(*) as total_visits'))
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        return collect(range(1, 7))->map(fn($day) => $query[$day]->total_visits ?? 0)->values()->toArray();
    }

    private function getAllVisitData($userId)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        $visits = Linkvisithistory::whereHas('link', fn($query) => $query->where('user_id', $userId))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYOFWEEK(created_at) as day'), DB::raw('COUNT(*) as total_visits'))
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        return collect(range(1, 7))->map(fn($day) => $visits[$day]->total_visits ?? 0)->values();
    }

    /**
     * Get visit history based on filter.
     */
    private function getVisitHistory($linkId, $filter)
    {
        $query = Linkvisithistory::where('link_id', $linkId);

        if ($filter === 'unique') {
            $query->where('is_unique', true);
        } elseif ($filter === 'redirected') {
            $query->where('status', 1);
        } elseif ($filter === 'rejected') {
            $query->where('status', 0);
        }

        return $query->latest()->paginate(10);
    }

    private function getLocationStatistic($linkId)
    {
        $locations = Linkvisithistory::where('link_id', $linkId)
            ->select('location', DB::raw('COUNT(*) as visit_count'))
            ->groupBy('location')
            ->get();
        return $locations->pluck('visit_count', 'location')->toArray();
    }


    /**
     * Get visit count by status.
     */
    private function getVisitCount($linkId, $status)
    {
        return Linkvisithistory::where('link_id', $linkId)
            ->where('status', $status)
            ->count();
    }

    /**
     * Authorize link access.
     */
    private function authorizeLink(Link $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }
    }
}