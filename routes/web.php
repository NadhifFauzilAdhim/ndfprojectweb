<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('home',['title' => 'Home']);
});

Route::get('/blog', function () {

    return view('blog',['title' => 'Blog', 'type'=> 'all' ,'posts' => Post::filter(request(['search','category','author']))->latest()->paginate(6)->withQueryString()]);
});

Route::get('/blog/{post:slug}', function (Post $post) {
    return view('post',['title' => $post['title'],'post' => $post]);
}); 

Route::get('author/{user:username}', function (User $user) {
       return view('blog',['title'=> 'Article By '.$user->name,'type'=> 'author','posts' =>  $user->posts]);
});

Route::get('category/{category:slug}', function (Category $category) {
    return view('blog',['title'=> 'Category '.$category->name,'type'=> 'category','posts' => $category->posts]);
});
//login
Route::get('/login',[LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login',[LoginController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::post('/logout',[LoginController::class, 'deauthenticate'])->name('deauthenticate')->middleware('auth');

//register
Route::get('/register',[RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register',[RegisterController::class, 'store'])->name('storeregister')->middleware('guest');

Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
