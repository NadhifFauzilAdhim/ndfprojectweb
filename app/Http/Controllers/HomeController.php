<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

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
}

