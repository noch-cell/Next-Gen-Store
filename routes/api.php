<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductCategory;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Vendor\VendorCategoryController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Vendor\VendorProductCategoryController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->group(function () {

    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('guest');
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/user', [AdminAuthController::class, 'getUser']);
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('categories', CategoryController::class);
    });
});
Route::prefix('vendor')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('guest');
});

// Vendor Routes
Route::prefix('vendor')->group(function () {
    Route::post('/register', [VendorAuthController::class, 'register']);
    Route::post('/login', [VendorAuthController::class, 'login'])->middleware('guest');

    Route::middleware(['auth:sanctum', 'vendor'])->group(function () {
        Route::get('/user', [VendorAuthController::class, 'getUser']);
        Route::post('/logout', [VendorAuthController::class, 'logout']);
        Route::apiResource('products', VendorProductController::class);
        Route::apiResource('categories', VendorCategoryController::class);
        Route::apiResource('product-category', VendorProductCategoryController::class);
    });
});

// User Routes
Route::prefix('user')->group(function () {
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout']);
});
