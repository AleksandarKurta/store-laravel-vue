<?php

namespace App\DTOs;

class ProductDTO
{
    public function __construct(
        public int $externalId,
        public string $title,
        public float $price,
        public string $description,
        public string $category,
        public string $image,
        public ProductRatingDTO $rating,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            externalId: $data['id'],
            title: $data['title'],
            price: $data['price'],
            description: $data['description'],
            category: $data['category'],
            image: $data['image'],
            rating: ProductRatingDTO::fromArray($data['rating']),
        );
    }
}
