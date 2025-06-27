<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\UserAuthController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guestOrVerified'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('home');
    Route::get('/category/{category:slug}', [ProductController::class, 'byCategory'])->name('byCategory');
    Route::get('/product/{product:slug}', [ProductController::class, 'view'])->name('product.view');

    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product:slug}', [CartController::class, 'add'])->name('add');
        Route::post('/remove/{product:slug}', [CartController::class, 'remove'])->name('remove');
        Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity'])->name('update-quantity');
    });
});

Route::get('/home', function () {
    return view('home.home');
})->name('home.home');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/register', function () {
    return view('auth.register');
})->name('user.register');

Route::post('/register', [UserAuthController::class, 'register'])->name('user.register');

 Route::get('/login', function () {
    return view('auth.login');
 })->name('user.login');

Route::post('/login', [UserAuthController::class, 'login'])->name('user.login');

Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth')->name('user.logout');
