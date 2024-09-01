<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home',[
            'title' => 'Home'
        ]);
    }

    public function blog()
    {
        return view('blog', [
            'title' => 'Blog',
            'type' => 'all',
            'posts' => Post::filter(request(['search', 'category', 'author']))->latest()->paginate(6)->withQueryString()
        ]);
    }

    public function showPost(Post $post)
    {
        return view('post', [
            'title' => $post['title'],
            'post' => $post
        ]);
    }

    public function showAuthor(User $user)
    {
        return view('blog', [
            'title' => 'Article By ' . $user->name,
            'type' => 'author',
            'posts' => $user->posts
        ]);
    }

    public function showCategory(Category $category)
    {
        return view('blog', [
            'title' => 'Category ' . $category->name,
            'type' => 'category',
            'posts' => $category->posts
        ]);
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'body' => $request->message,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Comment posted!');
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comment deleted!');
    }
}

