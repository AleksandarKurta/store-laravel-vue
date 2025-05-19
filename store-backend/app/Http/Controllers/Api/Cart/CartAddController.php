<?php

namespace App\Http\Controllers\Api\Cart;

use App\Exceptions\Cart\CartUpdateFailedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Http\Responses\ApiResponse;
use App\Services\Cart\AddToCartServiceInterface;

class CartAddController extends Controller
{
    public function __construct(
        private AddToCartServiceInterface $cartService
    ) {}

    public function __invoke(AddToCartRequest $request)
    {
        try {
            $cart = $this->cartService->addToCart(request()->user()?->id, $request->validated());

            return ApiResponse::success(new CartResource($cart), 'Added to cart successfully', 'data');
        } catch (CartUpdateFailedException $e) {
            return ApiResponse::error($e->getMessage(), 500);
        } catch (\Throwable $e) {
            return ApiResponse::error('An unexpected error occurred', 500);
        }
    }
}
