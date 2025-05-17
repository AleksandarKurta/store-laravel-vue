<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Product\ProductUpdateDTO;
use PHPUnit\Framework\TestCase;

class ProductUpdateDTOTest extends TestCase
{
    public function test_product_update_dto_from_array_creates_valid_dto()
    {
        $productUpdate = [
            'title' => 'Test Product',
            'description' => 'Test description',
            'image' => 'http://example.com/image.jpg',
            'price' => 99.99,
        ];

        $dto = ProductUpdateDTO::fromArray($productUpdate);

        $this->assertEquals('Test Product', $dto->title);
        $this->assertEquals('Test description', $dto->description);
        $this->assertEquals('http://example.com/image.jpg', $dto->image);
        $this->assertEquals(99.99, $dto->price);
    }
}
