<?php

namespace App\Http\Controllers\Api\Product;

use App\DTOs\Product\ProductUpdateDTO;
use App\Exceptions\Product\ProductUpdateFailedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Responses\ApiResponse;
use App\Models\Product;
use App\Services\Product\ProductUpdaterServiceInterface;
use Illuminate\Http\JsonResponse;

class UpdateProductController extends Controller
{
    public function __construct(
        private ProductUpdaterServiceInterface $productUpdaterService
    ) {}

    public function __invoke(UpdateProductRequest $request, Product $product): JsonResponse
    {
        try {
            $dto = ProductUpdateDTO::fromArray($request->validated());

            $updatedProduct = $this->productUpdaterService->update($product, $dto);

            return ApiResponse::success(
                new ProductResource($updatedProduct),
                'Product updated successfully',
                'product'
            );
        } catch (ProductUpdateFailedException $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }
}
