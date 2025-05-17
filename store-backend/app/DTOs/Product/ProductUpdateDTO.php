<?php

namespace App\DTOs\Product;

class ProductUpdateDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $image,
        public readonly float $price
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
            image: $data['image'],
            price: $data['price']
        );
    }
}
