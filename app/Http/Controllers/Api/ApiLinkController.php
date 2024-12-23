<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockedIp;
use App\Models\Link;
use App\Models\Linkvisithistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiLinkController extends Controller
{
    public function index(Request $request)
    {
        try {
            $totalLinks = Link::where('user_id', Auth::id())->count();
            $totalVisit = Link::where('user_id', Auth::id())->sum('visits');
            $totalUniqueVisit = Link::where('user_id', Auth::id())->sum('unique_visits');
            
            $search = $request->input('search');
            $links = Link::where('user_id', Auth::id())
                ->when($search, fn($query, $search) => $query->where('slug', 'like', "%{$search}%"))
                ->latest()
                ->paginate(6);
            
            $topLink = Link::where('user_id', Auth::id())
                ->orderByDesc('visits')
                ->take(4)
                ->get();

            return response()->json([
                'totalLinks' => $totalLinks,
                'totalVisit' => $totalVisit,
                'totalUniqueVisit' => $totalUniqueVisit,
                'links' => $links,
                'topLinks' => $topLink,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching data', 'error' => $e->getMessage()], 500);
        }
    }

    public function getVisitData()
    {
        try {
            $visits = Linkvisithistory::whereHas('link', function ($query) {
                    $query->where('user_id', Auth::id());
                })->select(DB::raw('DAYOFWEEK(created_at) as day'), DB::raw('COUNT(*) as total_visits'))
                ->groupBy('day')
                ->orderBy('day', 'asc')
                ->get();

            $visitData = [];
            foreach (range(1, 7) as $day) {
                $visitData[$day] = $visits->firstWhere('day', $day)->total_visits ?? 0;
            }

            return response()->json([
                'visitData' => array_values($visitData),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching visit data', 'error' => $e->getMessage()], 500);
        }
    }

    public function generateQRCode(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'data' => 'required|string|max:500',
                'size' => 'nullable|string|regex:/^\d+x\d+$/|max:10', 
            ]);
        
            $data = $validatedData['data'];
            $size = $validatedData['size'] ?? '200x200';
        
            $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/";
            $queryParams = http_build_query([
                'data' => $data,
                'size' => $size,
            ]);
        
            $qrCodeUrl = "{$qrApiUrl}?{$queryParams}";
        
            return response()->json([
                'success' => true,
                'message' => 'QR Code generated successfully.',
                'qrCodeUrl' => $qrCodeUrl,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error generating QR code', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Link $link, Request $request)
    {
        try {
            if ($link->user_id !== Auth::id()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            $filter = $request->query('filter', 'all');
            $query = Linkvisithistory::where('link_id', $link->id);

            if ($filter === 'unique') {
                $query->where('is_unique', true);
            } elseif ($filter === 'redirected') {
                $query->where('status', 1);
            } elseif ($filter === 'rejected') {
                $query->where('status', 0);
            }

            $visithistory = $query->latest()->paginate(10);

            $redirectedCount = Linkvisithistory::where('link_id', $link->id)->where('status', 1)->count();
            $rejectedCount = Linkvisithistory::where('link_id', $link->id)->where('status', 0)->count();

            $blockedIps = BlockedIp::where('link_id', $link->id)->get();

            $topReferers = Linkvisithistory::where('link_id', $link->id)
                ->select('referer_url', DB::raw('COUNT(*) as visit_count'))
                ->groupBy('referer_url')
                ->orderByDesc('visit_count')
                ->limit(5)
                ->get();

            return response()->json([
                'link' => $link,
                'visithistory' => $visithistory,
                'redirectedCount' => $redirectedCount,
                'rejectedCount' => $rejectedCount,
                'blockedIps' => $blockedIps,
                'filter' => $filter,
                'topReferers' => $topReferers,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching link details', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'target_url' => 'required|max:255|url',
                'slug' => 'required|max:255|unique:links',
            ]);

            $validatedData['user_id'] = Auth::id();
            $link = Link::create($validatedData);

            return response()->json([
                'message' => 'Link created successfully.',
                'link' => $link,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating link', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Link $link)
    {
        try {
            if ($link->user_id !== Auth::id()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            $validatedData = $request->validate([
                'target_url' => 'required|max:255|url',
                'slug' => 'required|max:255|unique:links,slug,' . $link->id,
                'password' => 'nullable|min:6|max:255',
            ]);

            $validatedData['password_protected'] = $request->has('password_protected') ? 1 : 0;
            $validatedData['password'] = $validatedData['password_protected']
                ? (!empty($request->password) ? bcrypt($request->password) : $link->password)
                : null;
            $validatedData['active'] = $request->has('active') ? 1 : 0;

            $link->update($validatedData);

            return response()->json([
                'message' => 'Link updated successfully.',
                'link' => $link,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating link', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Link $link)
    {
        try {
            if ($link->user_id !== Auth::id()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            $link->delete();

            return response()->json(['message' => 'Link deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting link', 'error' => $e->getMessage()], 500);
        }
    }
}
