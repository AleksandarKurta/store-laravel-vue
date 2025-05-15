<?php

namespace Tests\Unit\DTOs;

use App\DTOs\ProductDTO;
use PHPUnit\Framework\TestCase;

class ProductDTOTest extends TestCase
{
    public function test_product_dto_from_array_creates_valid_dto()
    {
        $product = [
            'id' => 1,
            'title' => 'Test Product',
            'price' => 99.99,
            'description' => 'Test description',
            'category' => 'test-category',
            'image' => 'http://example.com/image.jpg',
            'rating' => [
                'rate' => 4.5,
                'count' => 100,
            ],
        ];

        $dto = ProductDTO::fromArray($product);

        $this->assertEquals(1, $dto->externalId);
        $this->assertEquals('Test Product', $dto->title);
        $this->assertEquals(99.99, $dto->price);
        $this->assertEquals('test-category', $dto->category);
        $this->assertEquals(4.5, $dto->rating->rate);
        $this->assertEquals(100, $dto->rating->count);
    }
}
