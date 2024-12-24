<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiLinkController;
use App\Http\Controllers\Api\ApiBlockIpsController;


Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::get('/qrcode', [ApiLinkController::class, 'generateQRCode']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::apiResource('/posts', PostController::class );
    Route::get('/post/{slug}', [PostController::class, 'showBySlug']);
    Route::apiResource('links', ApiLinkController::class);
    Route::get('/visit-data', [ApiLinkController::class, 'getVisitData']);
    Route::apiResource('/block-ip',ApiBlockIpsController::class)->only('store','destroy','show');
    Route::get('/block-ip/{link_id}', [ApiBlockIpsController::class, 'show']);
});