<?php

namespace App\Services\Cart;

use App\Exceptions\Cart\CartUpdateFailedException;
use App\Models\Cart;
use App\Repositories\Cart\CartRepositoryInterface;

class GetCartService implements GetCartServiceInterface
{
    public function __construct(
        private CartRepositoryInterface $cartRepository
    ) {}

    public function getCart(string $cartToken):? Cart
    {
        return $this->cartRepository->getCartByToken($cartToken);
    }
}
