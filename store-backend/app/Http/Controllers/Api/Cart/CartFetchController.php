<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use App\Services\Cart\GetCartServiceInterface;

class CartFetchController extends Controller
{
    public function __construct(
        private GetCartServiceInterface $cartService
    ) {}

    public function __invoke(Request $request)
    {
        $cartToken = $request->query('cart_token');

        $cart = $this->cartService->getCart($cartToken);

        if (!$cart) {
            return ApiResponse::success(null, 'Cart is empty', 'data');
        }

        return ApiResponse::success(new CartResource($cart), 'Cart fetched successfully', 'data');
    }
}

