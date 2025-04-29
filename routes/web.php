<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\BlockedIpController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GauthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TrackingController;

// Public routes 
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/blog', [HomeController::class, 'blog']);
    Route::get('/blog/{post:slug}', [HomeController::class, 'showPost'])->name('blog.show');
    Route::get('author/{user:username}', [HomeController::class, 'showAuthor']);
    Route::get('category/{category:slug}', [HomeController::class, 'showCategory']);
    Route::get('/event', [EventController::class, 'index'])->name('event');
    Route::get('/event/{id}', [EventController::class, 'show'])->name('eventdetail');
});

Route::middleware('throttle:20,1')->group(function () {
    Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
    Route::get('/beloved', [HomeController::class, 'beloved'])->name('beloved');
    Route::get('/arabis', [HomeController::class, 'arabisindex'])->name('arabis');
    Route::get('/apidocumentation', [HomeController::class, 'ipdocuments'])->name('ipdocuments');
});

// Authentication routes 
Route::middleware('guest')->group(function() {
    Route::middleware('throttle:20,1')->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
        Route::get('/register', [RegisterController::class, 'index'])->name('register');    
        Route::post('/register', [RegisterController::class, 'store'])->name('storeregister');
        //Google Authentication
        Route::get('/oauth/google', [GauthController::class, 'redirectToProvider'])->name('oauth.google');
        Route::get('/oauth/google/callback', [GauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');
    });
    Route::middleware('throttle:20,1')->group(function () {
        Route::get('/forgot-password',[ForgotPasswordController::class,'passwordReset'])->name('password.request');
        Route::post('/forgot-password',[ForgotPasswordController::class,'resetRequest'])->name('password.email');
        Route::get('/reset-password/{token}',[ForgotPasswordController::class,'resetToken'])->name('password.reset');
        Route::post('/reset-password',[ForgotPasswordController::class,'resetForm'])->name('password.update');
    });
});

// Email Verification routes
Route::middleware('auth')->group(function() {
    Route::get('/email/verify', [RegisterController::class, 'verifyemail'])->name('verification.notice');
    Route::get('/email/verify-success', [RegisterController::class, 'verificationSuccess'])->name('verification.success');
    Route::post('/email/verification-notification', [RegisterController::class, 'verificationResend'])
        ->middleware('throttle:2,1')
        ->name('verification.send');
    Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'emailVerificationRequest'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/logout', [LoginController::class, 'deauthenticate'])->name('logout');
});

Route::middleware(['auth', 'verified'])->group(function() {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes 
    Route::middleware('throttle:20,1')->group(function () {
        Route::resource('/dashboard/profile', UserProfileController::class)->only(['index', 'update'])->parameters(['profile' => 'user:username']);
        Route::put('/dashboard/profile/{user:username}/change-image', [UserProfileController::class, 'changeProfileImage']);
    });

    // Password management 
    Route::middleware('throttle:3,1')->group(function () {
        Route::get('/dashboard/profile/change-password', [UserProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::get('/dashboard/profile/reset-password', [UserProfileController::class, 'showResetPasswordForm'])->name('profile.reset-password');
        Route::post('/dashboard/profile/update-password', [UserProfileController::class, 'updatePassword'])->name('profile.update-password');
    });

    // Comments dan Replies 
    Route::middleware('throttle:10,1')->group(function () {
        Route::post('/post/{post:slug}/comment', [CommentController::class, 'store']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        Route::post('/comments/{comment}/reply', [CommentController::class, 'reply']);
        Route::delete('/commentReply/{reply}', [CommentController::class, 'destroyReply'])->name('commentReply.destroy');
    });

    // Link management 
    Route::middleware('throttle:60,1')->group(function () {
        Route::resource('/dashboard/link', LinkController::class)->only(['index', 'store', 'show', 'destroy','update']);
        Route::post('/dashboard/link/{link}/update-title', [LinkController::class, 'updateTitle']);
        Route::post('/qrcode/generate',[LinkController::class,'qrcodegenerate'])->name('links.qrcodegenerate');
        Route::post('/qrcode/scan',[LinkController::class,'qrcodescan'])->name('links.qrcodescan');
        Route::post('/dashboard/link/share', [LinkController::class, 'share']);
        Route::delete('dashboard/link/share/{linkShare}', [LinkController::class, 'deleteShare'])->name('links.share.delete');
        // routes/web.php
        // Route::get('dashboard/tracking', \App\Livewire\TrackingIndex::class)->name('dashboard.tracking.index');
        Route::name('dashboard.')->group(function () {
            Route::resource('dashboard/tracking', TrackingController::class)->only(['index', 'store', 'show', 'destroy', 'update']);
        });
    });

    // Blocked IPs 
    Route::middleware('throttle:10,1')->group(function () {
        Route::post('/block-ip', [BlockedIpController::class, 'block'])->name('block.ip');
        Route::delete('/unblock-ip/{id}', [BlockedIpController::class, 'unblock'])->name('unblock.ip');
    });

    // Todo List 
    Route::middleware('throttle:60,1')->group(function () {
        Route::resource('/dashboard/todolist', TodoController::class);
        Route::put('/dashboard/todolist/{id}', [TodoController::class, 'update'])->name('todolist.update');
        Route::delete('/dashboard/todolist/{id}', [TodoController::class, 'destroy']);
    });
});

// Dashboard Admin routes 
Route::middleware(['auth', 'admin', 'verified'])->group(function() {
    Route::middleware('throttle:20,1')->group(function () {
        Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug']);
        Route::resource('/dashboard/posts', DashboardPostController::class);
        Route::post('/dashboard/posts/generate', [DashboardPostController::class, 'generatePost'])->name('posts.generate');
        Route::post('/dashboard/posts/{post:slug}/visibility', [DashboardPostController::class, 'visibility'])->name('posts.visibility');
        Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show');
        Route::delete('/dashboard/postmanagement/{post:slug}', [AdminPostController::class, 'destroy'])->name('postmanagement.destroy');
        Route::resource('/dashboard/postmanagement', AdminPostController::class)->only(['index','destroy']);
        
    });
});

// Owner-specific routes 
Route::middleware(['auth', 'owner', 'verified'])->group(function() {
    Route::middleware('throttle:5,1')->group(function () {
        Route::resource('/dashboard/usersetting', AdminUserController::class)->only(['index', 'update']);
        Route::patch('/dashboard/usersetting/{user}/toggle-verification', [AdminUserController::class, 'update'])->name('usersetting.toggleVerification');
        Route::get('/dashboard/usersetting/export', [AdminUserController::class, 'exportCSV'])->name('admin.users.export');

    });
});

// Redirect route 
Route::middleware('throttle:10,1')->group(function () {
    Route::get('/r/{link:slug}', RedirectController::class);
    Route::post('/r/{link:slug}', RedirectController::class)->name('link.redirect');
    Route::get('/r/{link:slug}', RedirectController::class)->name('link.access');
});