<?php

namespace App\Repositories\Product;

use App\DTOs\Product\ProductDTO;
use App\DTOs\Product\ProductRatingDTO;
use App\DTOs\Product\ProductUpdateDTO;
use App\Exceptions\Product\ProductUpdateFailedException;
use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements ProductRepositoryInterface
{
    public function saveProduct(ProductDTO $dto): Product
    {
        return Product::updateOrCreate(
            ['external_id' => $dto->externalId],
            [
                'title' => $dto->title,
                'price' => $dto->price,
                'description' => $dto->description,
                'category' => $dto->category,
                'image' => $dto->image,
                'synced_at' => now(),
            ]
        );
    }

    public function saveRating(int $productId, ProductRatingDTO $rating): void
    {
        ProductRating::updateOrCreate(
            ['product_id' => $productId],
            [
                'rate' => $rating->rate,
                'count' => $rating->count,
            ]
        );
    }

    public function updateProduct(Product $product, ProductUpdateDTO $dto): Product
    {
        $success = $product->update([
            'title' => $dto->title,
            'description' => $dto->description,
            'image' => $dto->image,
            'price' => $dto->price,
        ]);

        if (! $success) {
            throw new ProductUpdateFailedException;
        }

        return $product->fresh();
    }

    public function fetchProducts(int $limit = 20): Collection
    {
        return Product::select(['id', 'title', 'price', 'image', 'category'])
                ->take($limit)
                ->get();
    }
}
