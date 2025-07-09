<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use App\Models\BlockedIp;
use App\Models\LinkShare;
use App\Models\LinkCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Linkvisithistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use App\Notifications\linkShareNotif;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use App\Services\{LinkService,
                  AnalyticService,
                  ApiServices
                };

class LinkController extends Controller
{
    public function __construct(
        private LinkService $linkService,
        private AnalyticService $analyticService,
        private ApiServices $apiServices
        ){}
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $cacheKey = "user_{$userId}_dashboard";
        $search = $request->input('search');
        $categorySlug = $request->input('category');

        $data = Cache::remember($cacheKey, 300, function () use ($userId, $search) {
            return $this->analyticService->getDashboardData($userId);
        });
        extract($data);

        $links = Link::where('user_id', $userId)
            ->with('linkCategory')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('slug', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
                });
            })
            ->when($categorySlug, function ($query) use ($categorySlug) {
                if ($categorySlug === 'uncategorized') {
                    return $query->whereNull('link_category_id');
                }

                return $query->whereHas('linkCategory', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            })
            ->latest()
            ->paginate(12, ['*'], 'own_links')
            ->withQueryString();


        $linkCategories = LinkCategory::where('user_id', $userId)->orderBy('name')->get();

        $sharedLinks = Link::with('user') 
            ->join('link_shares', 'links.id', '=', 'link_shares.link_id')
            ->where('link_shares.shared_with', $userId)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('links.slug', 'like', "%{$search}%")
                    ->orWhere('links.title', 'like', "%{$search}%");
                });
            })
            ->select('links.*', 'link_shares.created_at as share_created_at') 
            ->orderBy('link_shares.created_at', 'desc') 
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
            'lastvisitData' => $lastvisitData,
            'linkCategories' => $linkCategories,
        ])->with('title', 'Linksy');
    }

    /**
     * Show the details of a specific link.
     */
    public function show(Link $link, Request $request)
    {
        $this->authorizeLink($link);
        $filter = $request->query('filter', 'all');
        $visithistory = $this->analyticService->getVisitHistory($link->id, $filter);
        $redirectedCount = Linkvisithistory::where('link_id', $link->id)->where('status', 1)->count();
        $rejectedCount = Linkvisithistory::where('link_id', $link->id)->where('status', 0)->count();

        $blockedIps = BlockedIp::where('link_id', $link->id)->get();
        $topReferersRaw = Linkvisithistory::where('link_id', $link->id)
            ->select('referer_url', DB::raw('COUNT(*) as visit_count'))
            ->whereNotNull('referer_url')
            ->where('referer_url', '!=', '')
            ->groupBy('referer_url')
            ->orderByDesc('visit_count')
            ->limit(5)
            ->get();
        $topReferers = [
            'labels' => $topReferersRaw->pluck('referer_url')->map(function ($url) {
                return $url ? parse_url($url, PHP_URL_HOST) : 'Direct';
            })->toArray(),
            'data' => $topReferersRaw->pluck('visit_count')->toArray(),
        ];
        $chartData = $this->analyticService->singleLinkStatistic($link->id, false);
        $location = $this->analyticService->getLocationStatistic($link->id);

        $countdown = [
            'target_time' => null,
            'message' => null,
            'status_class' => null,
        ];

        if ($link->scheduled) {
            $now = now();
            $startTime = $link->start_time ? Carbon::parse($link->start_time) : null;
            $endTime = $link->end_time ? Carbon::parse($link->end_time) : null;

            if ($startTime && $now->isBefore($startTime)) {
                $countdown['target_time'] = $startTime->toIso8601String();
                $countdown['message'] = 'Link akan menjadi aktif dalam:';
                $countdown['status_class'] = 'alert-primary';
            }
            elseif ($endTime && $now->isBefore($endTime)) {
                $countdown['target_time'] = $endTime->toIso8601String();
                $countdown['message'] = 'Link aktif dan akan kadaluarsa dalam:';
                $countdown['status_class'] = 'alert-warning';
            }
        }

        return view('dashboard.shortlink.linkdetail', compact(
            'link',
            'visithistory',
            'redirectedCount',
            'rejectedCount',
            'blockedIps',
            'filter',
            'chartData',
            'topReferers',
            'location',
            'countdown' 
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
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date',
        ]);

        if ($request->has('quickedit')) {
            $this->linkService->quickUpdate($validatedData, $link, $request);
            return redirect()->back()->with('success', 'Link updated successfully!');
        }

        $oldSlug = $link->slug;
        $link = $this->linkService->updateLink($validatedData, $link, $request);
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
        $this->authorizeLink($link);
        $validated = $request->validate([
            'title' => 'required|max:255',
        ]);
    
        $cleanTitle = htmlspecialchars($validated['title'], ENT_QUOTES, 'UTF-8');
        $cleanTitle = Str::limit($cleanTitle, 50);
    
        $link->update(['title' => $cleanTitle]);
        return response()->json(['success' => true, 'message' => 'Title updated!']);
    }

    /**
     * Store a newly created resource in storage.
     */
   
     public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'target_url' => 'required|max:255|url',
                'slug' => 'required|max:255|unique:links|regex:/^[\S]+$/|not_in:dashboard,admin,settings',
                'active' => 'required|boolean',
                'link_category_id' => 'nullable|exists:link_categories,id',
            ]);
            $link = $this->linkService->createLink($validatedData, Auth::id());
            return redirect()->back()->with('success', 'Link Berhasil Ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
                'send_notification' => 'boolean'
            ]);
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
            if ($request->send_notification) {
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
        $qrCode = $this->apiServices->qrCodeGenerate($request->url);
        return response($qrCode, 200)->header('Content-Type', 'image/png');
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
            $websiteTitle = 'scan' . ' ' . $this->apiServices->fetchWebsiteTitle($sanitizedUrl);
            $link = Link::create([
                'target_url' => $sanitizedUrl,
                'slug' => $slug,
                'title' => $websiteTitle,
                'user_id' => Auth::id(),
                'active' => true,
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
            $geminiCacheKey = 'summary_gemini_' . $link->id;
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
            $prompt .= "\nBuat ringkasan dalam 3 poin utama menggunakan Bahasa Indonesia yang mudah dimengerti oleh pengguna aplikasi (bukan teknikal). Tampilkan hasilnya langsung dalam format HTML dengan struktur berikut:\n" .
                    "<ul>\n" .
                    "<li><b>1. Tren Utama:</b> ...</li>\n" .
                    "<li><b>2. Pola Menarik:</b> ...</li>\n" .
                    "<li><b>3. Rekomendasi:</b> ...</li>\n" .
                    "</ul>";

            $model = 'gemini-2.0-flash';
            $response = $this->apiServices->generateGeminiResponse($prompt, $model, $geminiCacheKey);
            $data = [
                'summary' => $response,
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