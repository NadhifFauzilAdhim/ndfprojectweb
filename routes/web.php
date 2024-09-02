<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\UserProfileController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/blog', [HomeController::class, 'blog']);
Route::get('/blog/{post:slug}', [HomeController::class, 'showPost']);
Route::get('author/{user:username}', [HomeController::class, 'showAuthor']);
Route::get('category/{category:slug}', [HomeController::class, 'showCategory']);
//login
Route::get('/login',[LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login',[LoginController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::post('/logout',[LoginController::class, 'deauthenticate'])->name('logout')->middleware('auth');
//register
Route::get('/register',[RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register',[RegisterController::class, 'store'])->name('storeregister')->middleware('guest');

Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware(['auth','admin']);
Route::resource('/dashboard/usersetting', AdminUserController::class)->middleware(['auth','owner']);
Route::post('/post/{post:slug}/comment', [CommentController::class, 'store'])->middleware('auth');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');

Route::resource('/dashboard/profile', UserProfileController::class)->only(['index','update'])->parameters(['profile' => 'user:username'])->middleware('auth');
Route::put('/dashboard/profile/{user:username}/change-image', [UserProfileController::class, 'changeProfileImage'])->middleware('auth');
