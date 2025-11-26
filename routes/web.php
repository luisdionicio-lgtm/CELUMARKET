<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopPageController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;


// ---------------------------------------------------------------------------
// PUBLIC PAGES
// ---------------------------------------------------------------------------
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/tienda', [ShopPageController::class, 'index'])->name('shop.index');


// ---------------------------------------------------------------------------
// RESERVAS (public)
// ---------------------------------------------------------------------------
// Vista de reservas (solo listado)
Route::get('/reservas', [ReservationController::class, 'index'])->name('reservations.index');


// ---------------------------------------------------------------------------
// SHOPPING CART
// ---------------------------------------------------------------------------
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/reserve/{product}', [CartController::class, 'reserve'])->name('cart.reserve');
Route::post('/cart/compare/{product}', [CartController::class, 'compare'])->name('cart.compare');


// ---------------------------------------------------------------------------
// REDIRECT DASHBOARD TO SHOP
// ---------------------------------------------------------------------------
Route::get('/dashboard', function () {
    return redirect()->route('shop.index');
})->middleware(['auth', 'verified'])->name('dashboard');


// ---------------------------------------------------------------------------
// ADMIN ROUTES (only admins)
// ---------------------------------------------------------------------------
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Admin profile
        Route::get('/profile', [AdminProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::put('/profile/update', [AdminProfileController::class, 'update'])
            ->name('profile.update');
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])
            ->name('profile.password');

        // CRUD productos
        Route::resource('products', AdminProductController::class)
            ->names('products');

        Route::get('/test', function () {
            return 'Acceso permitido';
        })->name('test');
    });


// ---------------------------------------------------------------------------
// AUTHENTICATED USER ROUTES
// ---------------------------------------------------------------------------
Route::middleware('auth')->group(function () {

    // General user profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Favoritos
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Recursos comunes
    Route::resource('products', ProductController::class)->middleware('is_admin');
    Route::resource('orders', OrderController::class);
    Route::resource('tickets', TicketController::class);
    Route::get('/support', [TicketController::class, 'index'])->name('support.index');

    // RESERVAS (crear y cancelar)
    Route::post('/reservas/{product}', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservas/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // Comparaciones
    Route::get('/comparaciones', [ComparisonController::class, 'index'])->name('comparisons.index');
});


// ---------------------------------------------------------------------------
// Authentication modal (iframe)
// ---------------------------------------------------------------------------
Route::get('/auth/embed/login', fn() => view('auth.login'))->name('auth.embed.login');
Route::get('/auth/embed/register', fn() => view('auth.register'))->name('auth.embed.register');
Route::get('/auth/bridge', fn() => view('auth.bridge', ['to' => request('to', '/')]))->name('auth.bridge');


// ---------------------------------------------------------------------------
// Auth Scaffolding
// ---------------------------------------------------------------------------
require __DIR__ . '/auth.php';


//---------------------------------------------------------------------------
// Checkout Routes (Rutas de Pago)
//---------------------------------------------------------------------------
Route::middleware('auth')->group(function () {

    // --- CHECKOUT MULTIPASO ---
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.show');

    Route::get('/checkout/shipping', [CheckoutController::class, 'shipping'])->name('checkout.shipping');
    Route::post('/checkout/shipping', [CheckoutController::class, 'storeShipping'])->name('checkout.shipping.store');

    Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/payment', [CheckoutController::class, 'storePayment'])->name('checkout.payment.store');

    // Pagos QR (AJAX)
    Route::post('/checkout/payment/qr', [CheckoutController::class, 'generateQrPayment'])->name('checkout.payment.qr');
    Route::get('/checkout/payment/status/{payment}', [CheckoutController::class, 'checkQrStatus'])->name('checkout.payment.status');
    Route::post('/checkout/payment/qr/confirm', [CheckoutController::class, 'confirmQrCode'])->name('checkout.payment.qr.confirm');

    Route::get('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::match(['get', 'post'], '/checkout/complete', [CheckoutController::class, 'complete'])->name('checkout.complete');
});
