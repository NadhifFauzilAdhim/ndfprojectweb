<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Carbon;
use App\Models\Linkvisithistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnalyticService
{
    public function getDashboardData(int $userId)
    {
        $totals = Link::where('user_id', $userId)
            ->selectRaw('COUNT(*) as total_links, SUM(visits) as total_visits, SUM(unique_visits) as total_unique_visits')
            ->first();

        $sevenDaysAgo = Carbon::now()->subDays(7);
        $topLinks = Link::where('user_id', $userId)
            ->withCount(['visithistory as visits_last_7_days' => function ($query) use ($sevenDaysAgo) {
                $query->where('created_at', '>=', $sevenDaysAgo);
            }])
            ->orderByDesc('visits')
            ->take(10)
            ->get();

        $visitData = $this->getAllVisitData($userId);

        return compact('totals', 'topLinks', 'visitData');
    }


    public function singleLinkStatistic(int $linkId, bool $isUser = true)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->endOfWeek();
        $query = Linkvisithistory::when($isUser, fn($q) => $q->whereHas('link', fn($q) => $q->where('user_id', $linkId)))
            ->when(!$isUser, fn($q) => $q->where('link_id', $linkId))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYOFWEEK(created_at) as day'), DB::raw('COUNT(*) as total_visits'))
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');
        return collect(range(1, 7))->map(fn($day) => $query[$day]->total_visits ?? 0)->values()->toArray();
    }

    public function getVisitHistory(int $linkId, string $filter)
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

    public function getLocationStatistic(int $linkId)
    {
        $locations = Linkvisithistory::where('link_id', $linkId)
            ->select('location', DB::raw('COUNT(*) as visit_count'))
            ->groupBy('location')
            ->get();
        return $locations->pluck('visit_count', 'location')->toArray();
    }

    private function getAllVisitData(int $userId)
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
}


