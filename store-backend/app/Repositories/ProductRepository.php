<?php

namespace App\Repositories;

use App\DTOs\ProductDTO;
use App\DTOs\ProductRatingDTO;
use App\Models\Product;
use App\Models\ProductRating;

class ProductRepository implements ProductRepositoryInterface
{
    public function save(ProductDTO $dto): Product
    {
        $product = $this->saveProduct($dto);
        $this->saveRating($product->id, $dto->rating);

        return $product;
    }

    private function saveProduct(ProductDTO $dto): Product
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

    private function saveRating(int $productId, ProductRatingDTO $rating): void
    {
        ProductRating::updateOrCreate(
            ['product_id' => $productId],
            [
                'rate' => $rating->rate,
                'count' => $rating->count,
            ]
        );
    }
}
