<?php

namespace App\Http\Controllers\Api\Cart;

use App\Exceptions\Cart\CartUpdateFailedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Responses\ApiResponse;
use App\Services\Cart\AddToCartServiceInterface;

class AddToCartController extends Controller
{
    public function __construct(
        private AddToCartServiceInterface $cartService
    ) {}

    public function __invoke(AddToCartRequest $request)
    {
        try {
            $this->cartService->addToCart(request()->user()?->id, $request->validated());

            return ApiResponse::success(null, 'Added to cart successfully');
        } catch (CartUpdateFailedException $e) {
            return ApiResponse::error($e->getMessage(), 500);
        } catch (\Throwable $e) {
            return ApiResponse::error('An unexpected error occurred', 500);
        }
    }
}
