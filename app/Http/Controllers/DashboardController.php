<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $posts = Post::with(['author', 'category'])
            ->where('author_id', $userId)
            ->latest()
            ->paginate(4);

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
            'totalUniqueVisit' => $totalUniqueVisit
        ]);
    }
}
