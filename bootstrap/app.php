<?php

use Illuminate\Http\Request;
use App\Services\LinkService;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsOwner;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => IsAdmin::class,
            'owner' => IsOwner::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
         $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Not authenticated'
                ], 401);
            }
            
        });
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        // Jadwalkan command untuk menghapus visit history setiap hari
        $schedule->command('visit-history:cleanup')->daily();
    })->create();

    $app->bind(LinkService::class, function($app) {
        return new LinkService();
    });

    

