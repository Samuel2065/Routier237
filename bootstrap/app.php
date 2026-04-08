<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
        ]);

        // Redirect authenticated users away from guest routes
        $middleware->redirectUsersTo(function () {
            return auth()->check()
                ? auth()->user()->getDashboardRoute()
                : '/';
        });

        // Redirect unauthenticated users to the custom sign-in page.
        $middleware->redirectGuestsTo(function () {
            return route('sign_in');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
