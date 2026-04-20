<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$basePath = dirname(__DIR__); // raíz del proyecto

return Application::configure(basePath: $basePath)
    ->withRouting(
        web: $basePath . '/routes/web.php',
        commands: $basePath . '/routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web([
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->api([
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'barbero' => \App\Http\Middleware\BarberoMiddleware::class,
            'active' => \App\Http\Middleware\EnsureUserIsActive::class,
            'forzar_cambio_password' => \App\Http\Middleware\ForzarCambioPassword::class,
            'aceptar_terminos_crm'   => \App\Http\Middleware\AceptarTerminosCRM::class,
            'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
