<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Link;
use App\Models\User;
use App\Models\BlockedIp;
use App\Models\LinkShare;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Linkvisithistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use App\Notifications\linkShareNotif;
use Illuminate\Support\Facades\Notification;
use Gemini\Laravel\Facades\Gemini;



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
            'mySharedLinks' => $mySharedLinks,
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

        $validatedData['title'] = $websiteTitle ? Str::limit($websiteTitle, 50, '') : null;

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
        $startOfThisWeek = now()->startOfWeek();
        $endOfThisWeek = now()->endOfWeek();
        $thisWeekVisits = Linkvisithistory::whereHas('link', fn($q) => $q->where('user_id', $userId))
            ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->select(DB::raw('DAYOFWEEK(created_at) as day'), DB::raw('COUNT(*) as total_visits'))
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');
    
        $thisWeek = collect(range(1, 7))->map(fn($day) => $thisWeekVisits[$day]->total_visits ?? 0)->values();
        $lastWeekCacheKey = 'visit_data_last_week_' . $userId;
        $lastWeek = Cache::remember($lastWeekCacheKey, now()->addDays(7), function () use ($userId) {
            $startOfLastWeek = now()->subWeek()->startOfWeek();
            $endOfLastWeek = now()->subWeek()->endOfWeek();
            $lastWeekVisits = Linkvisithistory::whereHas('link', fn($q) => $q->where('user_id', $userId))
                ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                ->select(DB::raw('DAYOFWEEK(created_at) as day'), DB::raw('COUNT(*) as total_visits'))
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->keyBy('day');
            return collect(range(1, 7))->map(fn($day) => $lastWeekVisits[$day]->total_visits ?? 0)->values();
        });
        return [
            'thisWeek' => $thisWeek,
            'lastWeek' => $lastWeek,
        ];
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
      /**
     * Create A Share.
     */

    public function share(Request $request)
    {
      
        try {
            $validated = $request->validate([
                'link_id' => 'required|exists:links,slug',
                'shared_with' => 'required|exists:users,username',
                'send_notification' => 'boolean'
            ]);

            $sendingNotification = $request->send_notification ? true : false;
            $link = Link::where('slug', $request->link_id)->firstOrFail();
            $user = User::where('username', $request->shared_with)->firstOrFail();
            $sharedBy = Auth::user()->name;
            $fullUrl = 'https://linksy.site/' . $link->slug;
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
            if ($sendingNotification) {
                Notification::send($user, new linkShareNotif($link->title,$fullUrl, $sharedBy));
            }
            return response()->json(['message' => 'Link berhasil dibagikan'], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->errors(),
            ], 422); 
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete Share.
     */
    public function deleteShare($linkShareId)
    {
        $sharedLink = LinkShare::findOrFail($linkShareId);
        if ($sharedLink->link->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this shared link.');
        }
        $sharedLink->delete();
        return redirect()->back()->with('success', 'Link successfully removed from shared users.');
    }

    public function qrcodegenerate(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);
        $url = $request->input('url');
        $encodedUrl = urlencode($url);
        $apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={$encodedUrl}";
        $response = Http::get($apiUrl);
        if ($response->ok()) {
            $base64Image = 'data:image/png;base64,' . base64_encode($response->body());
            return response($base64Image, 200)->header('Content-Type', 'text/plain');
        }
        return response('Failed to generate QR Code.', 500);
    }

    public function qrcodescan(Request $request)
    {
        try {
            $validated = $request->validate([
                'url' => 'required|url|max:255',
            ]);
            $sanitizedUrl = filter_var($validated['url'], FILTER_SANITIZE_URL);
            if (!$sanitizedUrl) {
                return response()->json([
                    'success' => false,
                    'message' => 'URL tidak valid'
                ], 400);
            }
            do {
                $slug = 'scan' . '-' . Str::random(5);
                $slug = Str::limit($slug, 255, '');
            } while (Link::where('slug', $slug)->exists());
            $websiteTitle = 'scan' . ' ' . $this->fetchWebsiteTitle($sanitizedUrl);
            $link = Link::create([
                'target_url' => $sanitizedUrl,
                'slug' => $slug,
                'title' => $websiteTitle,
                'user_id' => Auth::id(),
                'active' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Link berhasil ditambahkan',
                'data' => $link
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateSummary(Link $link)
    {
        $this->authorizeLink($link);

        try {
            $cacheKey = 'summary_' . $link->id;
            $cached = Cache::get($cacheKey);

            if ($cached) {
                return response()->json([
                    'success' => true,
                    'summary' => $cached['summary'],
                    'stats' => $cached['stats']
                ]);
            }

            $totalVisits = $link->visits;
            $uniqueVisits = $link->unique_visits;
            $recentVisits = Linkvisithistory::where('link_id', $link->id)
                ->latest()
                ->take(5)
                ->get();

            // Cek jika tidak ada data kunjungan
            if ($totalVisits == 0 && $uniqueVisits == 0 && $recentVisits->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Belum ada data kunjungan untuk dianalisis.'
                ], 200);
            }

            $stats = [
                'Total Kunjungan' => $totalVisits,
                'Kunjungan Unik' => $uniqueVisits,
                'Lokasi Terbanyak' => $this->getMostCommonLocation($link->id),
                'Referer Utama' => $this->getTopReferer($link->id),
                'Device Populer' => $this->getDeviceStats($link->id),
                '5 Kunjungan Terakhir' => $recentVisits->map(fn($v) => [
                    'Waktu' => $v->created_at->format('d M Y H:i'),
                    'Status' => $v->status ? 'Redirected' : 'Blocked',
                    'Lokasi' => $v->location,
                    'Device' => $this->parseDevice($v->user_agent)
                ])->toArray()
            ];

            $prompt = "Berdasarkan data statistik berikut:\n";
            foreach ($stats as $label => $value) {
                $prompt .= "- $label: " . json_encode($value, JSON_UNESCAPED_SLASHES) . "\n";
            }
            $prompt .= "\nTampilkan ringkasan analisis dalam 3 poin utama dalam Bahasa Indonesia, dan outputkan langsung dalam format HTML tanpa kalimat pembuka. Gunakan tag <ul> dan <li> dengan format:\n" .
                    "<ul>\n" .
                    "<li><b>1. Tren Utama:</b> ...</li>\n" .
                    "<li><b>2. Pola Menarik:</b> ...</li>\n" .
                    "<li><b>3. Rekomendasi:</b> ...</li>\n" .
                    "</ul>";

            $model = 'gemini-2.0-flash';
            $response = Gemini::generativeModel($model)->generateContent($prompt);

            $data = [
                'summary' => $response->text(),
                'stats' => $stats
            ];

            Cache::put($cacheKey, $data, now()->addMinutes(30));

            return response()->json([
                'success' => true,
                'summary' => $data['summary'],
                'stats' => $data['stats']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating summary: ' . $e->getMessage()
            ], 500);
        }
    }

    // Helper methods
    private function getMostCommonLocation($linkId)
    {
        return Linkvisithistory::where('link_id', $linkId)
            ->select('location', DB::raw('count(*) as total'))
            ->groupBy('location')
            ->orderByDesc('total')
            ->first()->location ?? 'N/A';
    }

    private function getTopReferer($linkId)
    {
        return Linkvisithistory::where('link_id', $linkId)
            ->whereNotNull('referer_url')
            ->select('referer_url', DB::raw('count(*) as total'))
            ->groupBy('referer_url')
            ->orderByDesc('total')
            ->first()->referer_url ?? 'Direct';
    }

    private function getDeviceStats($linkId)
    {
        $devices = Linkvisithistory::where('link_id', $linkId)
            ->select('user_agent', DB::raw('count(*) as total'))
            ->groupBy('user_agent')
            ->orderByDesc('total')
            ->take(3)
            ->get()
            ->mapWithKeys(fn($item) => [$this->parseDevice($item->user_agent) => $item->total]);
        
        return $devices->all();
    }

    private function parseDevice($userAgent)
    {
        if (stripos($userAgent, 'Mobile') !== false) return 'Mobile';
        if (stripos($userAgent, 'Tablet') !== false) return 'Tablet';
        if (stripos($userAgent, 'Desktop') !== false) return 'Desktop';
        return 'Unknown';
    }

}