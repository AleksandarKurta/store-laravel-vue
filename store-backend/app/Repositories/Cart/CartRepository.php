<?php

namespace App\Repositories\Cart;

use App\Models\Cart;

class CartRepository implements CartRepositoryInterface
{
    public function findOrCreateCart(?int $userId, string $cartToken, string $sessionId): Cart
    {
        return Cart::firstOrCreate(
            ['user_id' => $userId, 'cart_token' => $cartToken],
            ['session_id' => $sessionId]
        );
    }

    public function addOrUpdateCartItem(Cart $cart, int $productId, int $quantity): void
    {
        $item = $cart->items()->where('product_id', $productId)->first();

        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
    }
}
