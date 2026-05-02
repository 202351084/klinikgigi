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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('dokter') || $request->is('dokter/*')) {
                return '/dokter/login';
            }

            return '/pasien/login';
        });

        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'doctor' => \App\Http\Middleware\EnsureDoctorAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
