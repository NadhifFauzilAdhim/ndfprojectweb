<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'title' => 'dashboard',
            'posts' => Post::with(['author', 'category', 'comments' => function ($query) {
             $query->latest();},'comments.user', 'comments.post'])->where('author_id', Auth::id())->latest()->paginate(3)
        ]);
    }
}
