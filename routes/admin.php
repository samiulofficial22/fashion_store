<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TaxRateSettingController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;

Route::prefix('admin')->name('admin.')->group(function() {

    // Guest routes
    Route::get('login', [AdminAuthController::class,'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class,'login'])->name('login.submit');
    Route::post('logout', [AdminAuthController::class,'logout'])->name('logout');

    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Users list
        Route::resource('users', UserController::class)->names('users');
        Route::get('users/{user}/export-pdf', [UserController::class, 'exportPdf'])->name('admin.users.export.pdf');

        // Future: Products CRUD routes
        // product category routes
        Route::resource('categories', CategoryController::class)->names('categories');
        Route::resource('products', ProductController::class)->names('products');
        Route::delete('product-image/{id}', [ProductController::class, 'deleteImage'])->name('product-image.delete');
        Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
        
        // Tax Rate Setting routes
        Route::get('/tax-rate-setting', [TaxRateSettingController::class, 'index'])->name('taxrate.index');
        Route::post('/tax-rate-setting', [TaxRateSettingController::class, 'update'])->name('taxrate.update');
        
        // Order Management
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        
        Route::get('notifications/orders', [NotificationController::class, 'getNewOrders'])->name('notifications.orders');
         
        // Admin Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');

        
        
        
    });
});
