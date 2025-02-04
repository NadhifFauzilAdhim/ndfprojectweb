<?php

namespace App\Http\Controllers;

use App\Models\BlockedIp;
use App\Models\Link;
use App\Models\Linkvisithistory;
use App\Models\LinkShare;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;


class LinkController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $cacheKey = "user_{$userId}_dashboard";
        $search = $request->input('search');
        // Cache entire dashboard data for 5 minutes
        $data = Cache::remember($cacheKey, 300, function () use ($userId, $search) {
            $totals = Link::where('user_id', $userId)
                ->selectRaw('COUNT(*) as total_links, SUM(visits) as total_visits, SUM(unique_visits) as total_unique_visits')
                ->first();

            $sevenDaysAgo = Carbon::now()->subDays(7);
            $topLinks = Link::where('user_id', $userId)
                ->withCount(['visithistory as visits_last_7_days' => function ($query) use ($sevenDaysAgo) {
                    $query->where('created_at', '>=', $sevenDaysAgo);
                }])
                ->orderByDesc('visits')
                ->take(5)
                ->get();

            $visitData = $this->getAllVisitData($userId);

            return compact(
                'totals',
                'topLinks',
                'visitData'
            );
        });
        extract($data);

        $links = Link::where('user_id', $userId)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->paginate(6, ['*'], 'own_links');

        $sharedLinks = Link::join('link_shares', 'links.id', '=', 'link_shares.link_id')
            ->where('link_shares.shared_with', $userId)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('links.slug', 'like', "%{$search}%")
                    ->orWhere('links.title', 'like', "%{$search}%");
                });
            })
            ->select('links.*')
            ->latest()
            ->paginate(6, ['*'], 'shared_links');

        $mySharedLinks = LinkShare::with('sharedWith')
            ->join('links', 'link_shares.link_id', '=', 'links.id')
            ->where('links.user_id', $userId)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('links.slug', 'like', "%{$search}%")
                    ->orWhere('links.title', 'like', "%{$search}%");
                });
            })
            ->select('link_shares.*')
            ->latest()
            ->paginate(6, ['*'], 'my_shared_links');


        return view('dashboard.shortlink.index', [
            'totalLinks' => (int)$totals->total_links,
            'totalVisit' => (int)$totals->total_visits,
            'totalUniqueVisit' => (int)$totals->total_unique_visits,
            'links' => $links,
            'topLinks' => $topLinks,
            'visitData' => $visitData,
            'sharedLinks' => $sharedLinks,
            'mySharedLinks' => $mySharedLinks
        ])->with('title', 'Short Link');
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
        return response()->json(['success' => true, 'message' => 'Title updated!']);
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
        if ($link->exists) {
            $link->delete();
            return redirect()->back()->with('success', 'Link Dihapus');
        }
        return redirect()->back()->with('error', 'Link sudah dihapus atau tidak ditemukan.');
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

    public function share(Request $request)
    {
        try {
            $validated = $request->validate([
                'link_id' => 'required|exists:links,slug',
                'shared_with' => 'required|exists:users,username',
            ]);
            $link = Link::where('slug', $request->link_id)->firstOrFail();
            $user = User::where('username', $request->shared_with)->firstOrFail();
            if ($user->id == Auth::id()) {
                return response()->json(['error' => 'Anda tidak dapat berbagi link Anda sendiri'], 400);
            }
            if ($link->user_id !== Auth::id()) {
                return response()->json(['error' => 'Anda tidak memiliki izin untuk berbagi link ini'], 403);
            }
            if (LinkShare::where('link_id', $link->id)->where('shared_with', $user->id)->exists()) {
                return response()->json(['error' => 'Link sudah dibagikan kepada pengguna ini'], 400);
            }
            LinkShare::create([
                'link_id' => $link->id,
                'shared_with' => $user->id,
            ]);

            return response()->json(['message' => 'Link berhasil dibagikan'], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->errors(),
            ], 422); 
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }


    public function deleteShare($linkShareId)
    {
        $sharedLink = LinkShare::findOrFail($linkShareId);
        if ($sharedLink->link->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this shared link.');
        }
        $sharedLink->delete();
        return redirect()->back()->with('success', 'Link successfully removed from shared users.');
    }

}