<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
            'customer' => \App\Http\Middleware\EnsureCustomer::class,
        ]);

        $middleware->redirectUsersTo(function (Request $request): string {
            $user = $request->user();

            if ($user?->isAdmin()) {
                return '/admin/dashboard';
            }

            return '/shop';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
