<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Models\TaxRateSetting;

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

//require __DIR__.'/auth.php';


//new code starts here 
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.show');


Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');




//tax rate api
Route::get('/api/tax-rate', function() {
    $tax = TaxRateSetting::first()?->tax_rate ?? 2.00;
    return response()->json(['tax_rate' => $tax]);
});


require __DIR__.'/admin.php';


