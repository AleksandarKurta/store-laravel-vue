<?php

namespace Tests\Unit\Repositories;

use App\DTOs\ProductDTO;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_persists_product_and_rating()
    {
        $product = [
            'id' => 1,
            'title' => 'Test Product',
            'price' => 49.99,
            'description' => 'A great product.',
            'category' => 'electronics',
            'image' => 'http://example.com/image.jpg',
            'rating' => [
                'rate' => 4.5,
                'count' => 200,
            ],
        ];

        $productDto = ProductDTO::fromArray($product);
        $repository = new ProductRepository;
        $repository->save($productDto);

        $this->assertDatabaseHas('products', [
            'external_id' => 1,
            'title' => 'Test Product',
        ]);

        $this->assertDatabaseHas('product_ratings', [
            'rate' => 4.5,
            'count' => 200,
        ]);
    }
}
