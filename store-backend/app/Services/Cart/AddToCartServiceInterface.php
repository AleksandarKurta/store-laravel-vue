<?php

namespace App\Services\Cart;

interface AddToCartServiceInterface
{
    public function addToCart(?int $userId, array $data): void;
}
