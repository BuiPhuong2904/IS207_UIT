<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        
        // Đăng ký route admin 
        then: function () {
            Route::middleware('web')->group(base_path('routes/admin.php'));
        }

    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Register IsAdmin middleware with both aliases for flexibility
        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'admin.role' => \App\Http\Middleware\IsAdmin::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
