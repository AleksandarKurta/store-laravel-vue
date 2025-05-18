<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;

class FetchProductsController extends Controller
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function __invoke(): JsonResponse
    {
        $products = $this->productRepository->fetchProducts();

        return ApiResponse::success(
            ProductResource::collection($products),
            'Products fetched successfully',
            'products'
        );
    }
}
