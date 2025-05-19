<?php

namespace App\Services\Cart;

use App\Models\Cart;

interface GetCartServiceInterface
{
    public function getCart(string $cartToken):? Cart;
}
