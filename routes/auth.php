<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Rutas accesibles solo para usuarios invitados (no autenticados)
Route::middleware('guest')->group(function () {
    // Mostrar formulario de registro
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // Procesar registro de usuario
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Mostrar formulario de inicio de sesión
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Procesar inicio de sesión
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Mostrar formulario para solicitar restablecimiento de contraseña
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // Enviar enlace de restablecimiento de contraseña por correo
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Mostrar formulario para establecer nueva contraseña (usando token)
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // Procesar nueva contraseña
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    // Vistas embebidas para iframe (solo formularios)
    Route::get('embed/login', function (Request $request) {
        return view('auth.embed-login');
    })->name('auth.embed.login.iframe');

    Route::get('embed/register', function (Request $request) {
        return view('auth.embed-register');
    })->name('auth.embed.register.iframe');
});

// Rutas accesibles solo para usuarios autenticados
Route::middleware('auth')->group(function () {
    // Mostrar aviso para verificar correo electrónico
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // Verificar correo electrónico con ID y hash
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Enviar nueva notificación de verificación de correo
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Mostrar formulario para confirmar contraseña antes de acciones sensibles
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    // Procesar confirmación de contraseña
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Actualizar contraseña del usuario autenticado
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Cerrar sesión del usuario
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// Página puente para cerrar el iframe y redirigir el documento superior
Route::get('auth/bridge', function (Request $request) {
    return view('auth.bridge', [
        'to' => $request->query('to', '/')
    ]);
})->name('auth.bridge');
