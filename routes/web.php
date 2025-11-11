<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopPageController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/tienda', [ShopPageController::class, 'index'])->name('shop.index');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/dashboard', function () {
    return redirect()->route('shop.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('/support', 'support.index')->name('support.index');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('tickets', TicketController::class);
});

//  RUTAS PARA EL MODAL DE AUTENTICACIÓN (iframe)
Route::get('/auth/embed/login', function () {
    return view('auth.login');
})->name('auth.embed.login');

Route::get('/auth/embed/register', function () {
    return view('auth.register');
})->name('auth.embed.register');

Route::get('/auth/bridge', function () {
    $to = request('to', '/'); // obtiene el destino
    return view('auth.bridge', ['to' => $to]);
})->name('auth.bridge');

require __DIR__.'/auth.php';
