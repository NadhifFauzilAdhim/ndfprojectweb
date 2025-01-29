<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Linkvisithistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $posts = Post::with(['author', 'category'])
            ->where('author_id', $userId)
            ->latest()
            ->paginate(3);

        $comments = Comment::with(['user', 'post.category', 'post.author'])
            ->whereIn('post_id', $posts->pluck('id'))
            ->latest()
            ->paginate(5);

        $totals = Link::where('user_id', $userId)
            ->selectRaw('COUNT(*) as total_links, SUM(visits) as total_visits, SUM(unique_visits) as total_unique_visits')
            ->first();

        $totalLinks = (int) $totals->total_links;
        $totalVisit = (int) $totals->total_visits;
        $totalUniqueVisit = (int) $totals->total_unique_visits;
        $visitData = $this->getAllVisitData($userId);

        $lastLinkVisit = Linkvisithistory::with('link') 
        ->whereHas('link', fn($query) => $query->where('user_id', $userId))
        ->latest()
        ->take(6)
        ->get();

        $topLinks = Link::with('user') 
            ->where('user_id', $userId)
            ->orderByDesc('visits')
            ->take(5)
            ->get();

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'posts' => $posts,
            'comments' => $comments,
            'topLinks' => $topLinks,
            'totalLinks' => $totalLinks,
            'totalVisit' => $totalVisit,
            'totalUniqueVisit' => $totalUniqueVisit,
            'lastLinkVisit' => $lastLinkVisit,
            'visitData' => $visitData
        ]);

        
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
}
