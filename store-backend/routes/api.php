<?php

use App\Http\Controllers\Api\Product\UpdateProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->put('/update/product/{product}', UpdateProductController::class);
