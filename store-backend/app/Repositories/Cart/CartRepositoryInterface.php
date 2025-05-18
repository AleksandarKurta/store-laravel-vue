<?php

namespace App\Repositories\Cart;

use App\Models\Cart;

interface CartRepositoryInterface
{
    public function findOrCreateCart(?int $userId, string $cartToken, string $sessionId): Cart;

    public function addOrUpdateCartItem(Cart $cart, int $productId, int $quantity): void;
}
