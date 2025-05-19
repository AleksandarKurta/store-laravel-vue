<?php

namespace App\Services\Cart;

use App\Exceptions\Cart\CartUpdateFailedException;
use App\Models\Cart;
use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AddToCartService implements AddToCartServiceInterface
{
    public function __construct(
        private CartRepositoryInterface $cartRepository
    ) {}

    public function addToCart(?int $userId, array $data): Cart
    {
        try {
            DB::beginTransaction();

            $cart = $this->cartRepository->findOrCreateCart(
                $userId,
                $data['cart_token'],
                session()->getId()
            );

            $this->cartRepository->addOrUpdateCartItem(
                $cart,
                $data['product_id'],
                $data['quantity']
            );

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw new CartUpdateFailedException('Failed to add product to cart');
        }

        return $cart->load('items.product');
    }
}
