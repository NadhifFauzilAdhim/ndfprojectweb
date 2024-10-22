<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $postIds = Post::where('author_id', Auth::id())
            ->pluck('id');
        $posts = Post::with(['author', 'category'])
            ->whereIn('id', $postIds)
            ->latest()
            ->paginate(4);

        $comments = Comment::with(['user', 'post'])
            ->whereIn('post_id', $postIds)
            ->latest()
            ->paginate(5);
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'posts' => $posts,
            'comments' => $comments,
        ]);
    }
}

