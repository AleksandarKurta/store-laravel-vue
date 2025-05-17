<?php

namespace Tests\Unit\Services;

use App\DTOs\Product\ProductUpdateDTO;
use App\Exceptions\Product\ProductUpdateFailedException;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Product\ProductUpdaterService;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

class ProductUpdaterServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_throws_exception_when_repository_fails_to_update(): void
    {
        $repo = Mockery::mock(ProductRepositoryInterface::class);
        $service = new ProductUpdaterService($repo);
        $product = new Product;
        $dto = new ProductUpdateDTO('Test', 'Desc', 'url.jpg', 9.99);

        $repo->shouldReceive('updateProduct')
            ->with($product, $dto)
            ->andThrow(new ProductUpdateFailedException);

        $this->expectException(ProductUpdateFailedException::class);

        $service->update($product, $dto);
    }

    public function test_updates_product_successfully(): void
    {
        $repo = Mockery::mock(ProductRepositoryInterface::class);
        $service = new ProductUpdaterService($repo);

        $product = Product::factory()->make();
        $dto = new ProductUpdateDTO('Updated Title', 'Updated Desc', 'image.jpg', 49.99);

        $repo->shouldReceive('updateProduct')
            ->once()
            ->with($product, $dto)
            ->andReturn($product);

        $result = $service->update($product, $dto);

        $this->assertSame($product, $result);
    }
}
