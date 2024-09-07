<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\UserProfileController;

// Public routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/blog', [HomeController::class, 'blog']);
Route::get('/blog/{post:slug}', [HomeController::class, 'showPost']);
Route::get('author/{user:username}', [HomeController::class, 'showAuthor']);
Route::get('category/{category:slug}', [HomeController::class, 'showCategory']);

// Authentication routes
Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('storeregister');
    Route::get('/forgot-password',[ForgotPasswordController::class,'passwordReset'])->name('password.request');
    Route::post('/forgot-password',[ForgotPasswordController::class,'resetRequest'])->name('password.email');
    Route::get('/reset-password/{token}',[ForgotPasswordController::class,'resetToken'])->name('password.reset');
    Route::post('/reset-password',[ForgotPasswordController::class,'resetForm'])->name('password.update');
});

// Email Verification routes
Route::middleware('auth')->group(function() {
    Route::get('/email/verify', [RegisterController::class, 'verifyemail'])->name('verification.notice');
    Route::get('/email/verify-success', [RegisterController::class, 'verificationSuccess'])->name('verification.success');
    Route::post('/email/verification-notification', [RegisterController::class, 'verificationResend'])->middleware('throttle:2,1')->name('verification.send');
    Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'emailVerificationRequest'])->middleware('signed')->name('verification.verify');
});

// Dashboard routes
Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Posts
    Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug']);
    Route::resource('/dashboard/posts', DashboardPostController::class);
    // Profile
    Route::resource('/dashboard/profile', UserProfileController::class)->only(['index', 'update'])->parameters(['profile' => 'user:username']);
    Route::put('/dashboard/profile/{user:username}/change-image', [UserProfileController::class, 'changeProfileImage']);
    // Comments and Replies
    Route::post('/post/{post:slug}/comment', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/reply', [CommentController::class, 'reply']);
    Route::delete('/commentReply/{reply}', [CommentController::class, 'destroyReply'])->name('commentReply.destroy');
});

// Dashboard Admin routes
Route::middleware(['auth', 'admin', 'verified'])->group(function() {
    Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show');
});

// Owner-specific routes
Route::middleware(['auth', 'owner', 'verified'])->group(function() {
    Route::resource('/dashboard/usersetting', AdminUserController::class);
});

// Logout
Route::post('/logout', [LoginController::class, 'deauthenticate'])->name('logout')->middleware('auth');
