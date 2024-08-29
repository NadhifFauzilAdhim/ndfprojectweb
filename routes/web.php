<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home',['title' => 'Home']);
});

Route::get('/blog', function () {
    return view('blog',['title' => 'Blog' ,'posts' => Post::all() ]);
});

Route::get('/blog/{post:slug}', function (Post $post) {
    return view('post',[
        'title' => $post['title'],
        'post' => $post]);
}); 

Route::get('author/{user:username}', function (User $user) {
    return view('authorblog',['title'=> 'Article By '.$user->name, 'posts' => $user->posts]);
});

