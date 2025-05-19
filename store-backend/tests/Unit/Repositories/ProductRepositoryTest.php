<?php

namespace Tests\Unit\Repositories;

use App\DTOs\Product\ProductDTO;
use App\DTOs\Product\ProductUpdateDTO;
use App\Exceptions\Product\ProductUpdateFailedException;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_persists_product_and_rating(): void
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

        $repository->saveProduct($productDto);

        $repository->saveRating($product['id'], $productDto->rating);

        $this->assertDatabaseHas('products', [
            'external_id' => 1,
            'title' => 'Test Product',
        ]);

        $this->assertDatabaseHas('product_ratings', [
            'rate' => 4.5,
            'count' => 200,
        ]);
    }

    public function test_it_updates_product_successfully(): void
    {
        $product = Product::factory()->create();

        $dto = new ProductUpdateDTO(
            title: 'Updated Title',
            description: 'Updated description',
            image: 'http://example.com/image.jpg',
            price: 99.99
        );

        $repository = new ProductRepository;
        $updated = $repository->updateProduct($product, $dto);

        $this->assertEquals('Updated Title', $updated->title);
        $this->assertEquals('Updated description', $updated->description);
        $this->assertEquals('http://example.com/image.jpg', $updated->image);
        $this->assertEquals(99.99, $updated->price);
    }

    public function test_it_throws_exception_on_update_failure(): void
    {
        $this->expectException(ProductUpdateFailedException::class);

        $dto = new ProductUpdateDTO(
            title: 'Fail Title',
            description: 'Fail description',
            image: 'fail.jpg',
            price: 0.0
        );

        $repository = new ProductRepository;

        $mockedProduct = Mockery::mock(Product::class)->makePartial();
        $mockedProduct->shouldReceive('update')->andReturn(false);

        $repository->updateProduct($mockedProduct, $dto);
    }

    public function test_fetch_products_returns_limited_records_with_selected_columns(): void
    {
        Product::factory()->count(30)->create();

        $repository = new ProductRepository;

        $result = $repository->fetchProducts(10);

        $this->assertCount(10, $result);

        $product = $result->first();
        $this->assertArrayHasKey('id', $product->getAttributes());
        $this->assertArrayHasKey('title', $product->getAttributes());
        $this->assertArrayHasKey('price', $product->getAttributes());
        $this->assertArrayHasKey('image', $product->getAttributes());
        $this->assertArrayHasKey('category', $product->getAttributes());

        $this->assertArrayNotHasKey('created_at', $product->getAttributes());
        $this->assertArrayNotHasKey('updated_at', $product->getAttributes());
    }

    public function test_fetch_products_is_cached()
    {
        Cache::shouldReceive('remember')
            ->once()
            ->with(
                'products_fetch',
                \Mockery::type(\DateTimeInterface::class),
                \Mockery::on(function ($closure) {
                    $result = $closure();

                    return $result instanceof \Illuminate\Support\Collection;
                })
            )
            ->andReturn(collect());

        $repository = new ProductRepository;

        $repository->fetchProducts(10);

        $this->assertTrue(true); // Prevents risky test warning
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
