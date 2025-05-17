<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\FakeStoreProductImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FakeStoreProductImportServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_imports_products_and_ratings_successfully()
    {
        Http::fake([
            'fakestoreapi.com/products' => Http::response([
                [
                    'id' => 1,
                    'title' => 'Test Product',
                    'price' => 19.99,
                    'description' => 'Sample product description',
                    'category' => 'electronics',
                    'image' => 'https://example.com/image.jpg',
                    'rating' => [
                        'rate' => 4.5,
                        'count' => 100,
                    ],
                ],
            ]),
        ]);

        $repository = new ProductRepository;
        $service = new FakeStoreProductImportService($repository);

        $importedTitles = $service->import();

        $this->assertContains('Test Product', $importedTitles);

        $this->assertDatabaseHas('products', [
            'external_id' => 1,
            'title' => 'Test Product',
            'price' => 19.99,
            'category' => 'electronics',
        ]);

        $product = Product::where('external_id', 1)->first();
        $this->assertNotNull($product);

        $this->assertDatabaseHas('product_ratings', [
            'product_id' => $product->id,
            'rate' => 4.5,
            'count' => 100,
        ]);
    }

    public function test_it_throws_exception_when_api_fails()
    {
        Http::fake([
            'fakestoreapi.com/products' => Http::response(null, 500),
        ]);

        $repository = new ProductRepository;
        $service = new FakeStoreProductImportService($repository);

        $this->expectException(\App\Exceptions\Product\ProductImportFailedException::class);

        $service->import();
    }
}
