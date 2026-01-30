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
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'surat.access' => \App\Http\Middleware\EnsureSuratAccess::class,
            'surat.intended' => \App\Http\Middleware\SetSuratIntendedRedirect::class,
            'surat.permission' => \App\Http\Middleware\EnsureSuratPermission::class,
            'role.author' => \App\Http\Middleware\EnsureUserIsAuthor::class,
            'author.permission' => \App\Http\Middleware\EnsureAuthorPermission::class,
            'dashboard.permission' => \App\Http\Middleware\EnsureDashboardPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
