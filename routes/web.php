<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\UserAuthController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guestOrVerified'])->group(function () {
    Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('home');
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
    return view('home');
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::post('/register', function () {
    return view('auth.register');
})->name('user.register.form');

Route::post('/register', [UserAuthController::class, 'register'])->name('user.register');

Route::post('/login', function () {
    return view('auth.login');
})->name('user.login.form');

Route::post('/login', [UserAuthController::class, 'login'])->name('user.login');

Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth')->name('user.logout');


//Route::middleware(['auth', 'verified'])->group(function() {
//    Route::get('/profile', [ProfileController::class, 'view'])->name('profile');
//    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.update');
//    Route::post('/profile/password-update', [ProfileController::class, 'passwordUpdate'])->name('profile_password.update');
//    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
//    Route::post('/checkout/{order}', [CheckoutController::class, 'checkoutOrder'])->name('cart.checkout-order');
//    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
//    Route::get('/checkout/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');
//    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
//    Route::get('/orders/{order}', [OrderController::class, 'view'])->name('order.view');
//});
