<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ShopPageController;
use App\Http\Controllers\CartController;

// Ruta principal que muestra la página de inicio
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Ruta que muestra la tienda (catálogo de productos)
Route::get('/tienda', [ShopPageController::class, 'index'])->name('shop.index');

// Grupo de rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Ruta para agregar un producto al carrito
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
});

// Ruta del dashboard, redirige a la tienda si el usuario está autenticado y verificado
Route::get('/dashboard', function () {
    return redirect()->route('shop.index'); 
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas para gestionar el perfil del usuario autenticado
Route::middleware('auth')->group(function () {
    // Mostrar formulario de edición de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Actualizar datos del perfil
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Eliminar cuenta del usuario
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Carga las rutas de autenticación definidas en auth.php
require __DIR__.'/auth.php';