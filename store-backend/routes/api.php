<?php

use App\Http\Controllers\Api\Product\FetchProductsController;
use App\Http\Controllers\Api\Product\UpdateProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', FetchProductsController::class)->name('index');
});

Route::prefix('product')->name('product.')->group(function () {
    Route::middleware('auth:sanctum')->put('/{product}', UpdateProductController::class)->name('update');
});
