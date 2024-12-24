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
            $userId = Auth::id();

            $statistics = $this->getUserLinkStatistics($userId);

            $links = Link::where('user_id', $userId)
                ->when($request->input('search'), fn($query, $search) => $query->where('slug', 'like', "%{$search}%"))
                ->latest()
                ->paginate(6);

            $topLinks = Link::where('user_id', $userId)
                ->orderByDesc('visits')
                ->take(4)
                ->get();

            return response()->json(array_merge($statistics, [
                'links' => $links,
                'topLinks' => $topLinks,
            ]));
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error fetching data');
        }
    }

    public function getVisitData()
    {
        try {
            $userId = Auth::id();

            $visitData = $this->getVisitStatistics($userId);

            return response()->json(['visitData' => $visitData]);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error fetching visit data');
        }
    }

    public function generateQRCode(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'data' => 'required|string|max:500',
                'size' => 'nullable|string|regex:/^\d+x\d+$/|max:10',
            ]);

            $qrCodeUrl = $this->createQRCodeUrl($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'QR Code generated successfully.',
                'qrCodeUrl' => $qrCodeUrl,
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error generating QR code');
        }
    }

    public function show(Link $link, Request $request)
    {
        try {
            $this->authorizeLink($link);

            $details = $this->getLinkDetails($link, $request);

            return response()->json($details);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error fetching link details');
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateLinkData($request);

            $link = Link::create($validatedData);

            return response()->json([
                'message' => 'Link created successfully.',
                'link' => $link,
            ], 201);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error creating link');
        }
    }

    public function update(Request $request, Link $link)
    {
        try {
            $this->authorizeLink($link);

            $validatedData = $this->validateLinkData($request, $link);

            $link->update($validatedData);

            return response()->json([
                'message' => 'Link updated successfully.',
                'link' => $link,
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating link');
        }
    }

    public function destroy(Link $link)
    {
        try {
            $this->authorizeLink($link);

            $link->delete();

            return response()->json(['message' => 'Link deleted successfully.']);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error deleting link');
        }
    }

    private function authorizeLink(Link $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(response()->json(['message' => 'Forbidden'], 403));
        }
    }

    private function handleException(\Exception $e, string $defaultMessage)
    {
        return response()->json([
            'message' => $defaultMessage,
            'error' => $e->getMessage(),
        ], 500);
    }

    private function getUserLinkStatistics($userId)
    {
        return [
            'totalLinks' => Link::where('user_id', $userId)->count(),
            'totalVisit' => Link::where('user_id', $userId)->sum('visits'),
            'totalUniqueVisit' => Link::where('user_id', $userId)->sum('unique_visits'),
        ];
    }

    private function getVisitStatistics($userId)
    {
        $visits = Linkvisithistory::whereHas('link', fn($query) => $query->where('user_id', $userId))
            ->select(DB::raw('DAYOFWEEK(created_at) as day'), DB::raw('COUNT(*) as total_visits'))
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        return collect(range(1, 7))->map(fn($day) => $visits[$day]->total_visits ?? 0)->values();
    }

    private function createQRCodeUrl($validatedData)
    {
        return "https://api.qrserver.com/v1/create-qr-code/?" . http_build_query([
            'size' => $validatedData['size'] ?? '200x200',
            'data' => $validatedData['data'],
        ]);
    }

    private function getLinkDetails(Link $link, Request $request)
    {
        $filter = $request->query('filter', 'all');

        return [
            'link' => $link,
            'visithistory' => Linkvisithistory::where('link_id', $link->id)
                ->when($filter === 'unique', fn($q) => $q->where('is_unique', true))
                ->when($filter === 'redirected', fn($q) => $q->where('status', 1))
                ->when($filter === 'rejected', fn($q) => $q->where('status', 0))
                ->latest()
                ->paginate(10),
            'redirectedCount' => Linkvisithistory::where('link_id', $link->id)->where('status', 1)->count(),
            'rejectedCount' => Linkvisithistory::where('link_id', $link->id)->where('status', 0)->count(),
            'blockedIps' => BlockedIp::where('link_id', $link->id)->get(),
            'filter' => $filter,
            'topReferers' => Linkvisithistory::where('link_id', $link->id)
                ->select('referer_url', DB::raw('COUNT(*) as visit_count'))
                ->groupBy('referer_url')
                ->orderByDesc('visit_count')
                ->take(5)
                ->get(),
        ];
    }

    private function validateLinkData(Request $request, Link $link = null)
    {
        $rules = [
            'target_url' => 'required|max:255|url',
            'slug' => 'required|max:255|unique:links,slug' . ($link ? ',' . $link->id : ''),
            'password' => 'nullable|min:6|max:255',
        ];

        $validatedData = $request->validate($rules);

        $validatedData['user_id'] = Auth::id();
        $validatedData['password_protected'] = $request->has('password_protected');
        $validatedData['password'] = $validatedData['password_protected']
            ? (!empty($request->password) ? bcrypt($request->password) : $link?->password)
            : null;
        $validatedData['active'] = $request->has('active');

        return $validatedData;
    }
}
