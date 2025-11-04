<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Auth\QuickLoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Models\TaxRateSetting;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product page
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.show');

// Cart routes
Route::prefix('cart')->group(function () {
    Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
});

// Checkout routes (public for guest)
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/store', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Order history (logged-in user only)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Tax rate API
Route::get('/api/tax-rate', function() {
    $tax = TaxRateSetting::first()?->tax_rate ?? 2.00;
    return response()->json(['tax_rate' => $tax]);
});
/*
|--------------------------------------------------------------------------
| Quick Login (Email or Phone)
|--------------------------------------------------------------------------
*/
Route::get('/login-modal', [QuickLoginController::class, 'showLoginForm'])->name('quick.login');
Route::post('/quick-login', [QuickLoginController::class, 'submit'])->name('quick.login.post');

/*
|--------------------------------------------------------------------------
| Google Login Routes
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Auth routes (Breeze)
require __DIR__.'/auth.php';

// Admin routes
require __DIR__.'/admin.php';
