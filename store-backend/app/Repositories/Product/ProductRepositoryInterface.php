<?php

namespace App\Repositories\Product;

use App\DTOs\Product\ProductDTO;
use App\DTOs\Product\ProductRatingDTO;
use App\DTOs\Product\ProductUpdateDTO;
use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function saveProduct(ProductDTO $dto): Product;

    public function saveRating(int $productId, ProductRatingDTO $rating): void;

    public function updateProduct(Product $product, ProductUpdateDTO $dto): Product;

    public function fetchProducts(int $perPage = 20): Collection;
}
