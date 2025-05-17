<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Product\ProductRatingDTO;
use PHPUnit\Framework\TestCase;

class ProductRatingDTOTest extends TestCase
{
    public function test_product_rating_dto_from_array_creates_valid_dto()
    {
        $productRating = [
            'rate' => 4.5,
            'count' => 100,
        ];

        $dto = ProductRatingDTO::fromArray($productRating);

        $this->assertEquals(4.5, $dto->rate);
        $this->assertEquals(100, $dto->count);
    }
}
