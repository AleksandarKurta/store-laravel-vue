<?php

namespace App\Services\Product;

use App\DTOs\Product\ProductUpdateDTO;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductUpdaterService implements ProductUpdaterServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function update(Product $product, ProductUpdateDTO $dto): Product
    {
        return $this->productRepository->updateProduct($product, $dto);
    }
}
