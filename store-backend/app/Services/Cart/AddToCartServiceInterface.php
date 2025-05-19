<?php

namespace App\Services\Cart;

use App\Models\Cart;

interface AddToCartServiceInterface
{
    public function addToCart(?int $userId, array $data): Cart;
}
