<?php

namespace App\DTOs;

class ProductRatingDTO
{
    public function __construct(
        public float $rate,
        public int $count
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            rate: $data['rate'],
            count: $data['count'],
        );
    }
}
