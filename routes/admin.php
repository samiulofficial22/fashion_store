<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;

Route::prefix('admin')->name('admin.')->group(function() {

    // Guest routes
    Route::get('login', [AdminAuthController::class,'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class,'login'])->name('login.submit');
    Route::post('logout', [AdminAuthController::class,'logout'])->name('logout');

    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
          Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');

        // Future: Products CRUD routes
        // Route::resource('products', AdminProductController::class);
    });
});
