<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Configura e inicializa la aplicación Laravel
return Application::configure(basePath: dirname(__DIR__))

    // Define las rutas principales de la aplicación
    ->withRouting(
        web: __DIR__.'/../routes/web.php',       // Rutas web (HTTP)
        commands: __DIR__.'/../routes/console.php', // Comandos Artisan personalizados
        health: '/up',                            // Ruta de verificación de estado (health check)
    )

    // Configura el middleware global de la aplicación
    ->withMiddleware(function (Middleware $middleware): void {
        // Aquí puedes registrar middlewares personalizados si lo necesitas
    })

    // Configura el manejo de excepciones de la aplicación
    ->withExceptions(function (Exceptions $exceptions): void {
        // Aquí puedes personalizar el reporte o renderizado de excepciones
    })

    // Crea y devuelve la instancia de la aplicación
    ->create();