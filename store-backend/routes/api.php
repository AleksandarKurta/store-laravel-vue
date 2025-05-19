<?php

use App\Http\Controllers\Api\Cart\CartAddController;
use App\Http\Controllers\Api\Cart\CartFetchController;
use App\Http\Controllers\Api\Product\ProductsGetController;
use App\Http\Controllers\Api\Product\ProductUpdateController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', ProductsGetController::class)->name('index');
});

Route::prefix('product')->name('product.')->group(function () {
    Route::middleware('auth:sanctum')->put('/{product}', ProductUpdateController::class)->name('update');
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('/add', CartAddController::class)->name('add');
    Route::get('/get', CartFetchController::class)->name('get');
});
