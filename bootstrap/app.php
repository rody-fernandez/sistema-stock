<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// ...
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // ...
    )
    ->withMiddleware(function (Middleware $middleware) {
        // tus otros aliases...
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class, // 👈 aquí
        ]);
    })
    ->withExceptions(function ($exceptions) {
        //
    })->create();
