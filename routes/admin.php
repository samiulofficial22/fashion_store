<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->name('admin.')->group(function() {

    // Guest routes
    Route::get('login', [AdminAuthController::class,'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class,'login'])->name('login.submit');
    Route::post('logout', [AdminAuthController::class,'logout'])->name('logout');

    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
          Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');

        // Future: Products CRUD routes
        //product category routes
         Route::resource('categories', CategoryController::class)->names('categories');
    });
});
