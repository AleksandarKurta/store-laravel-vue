<?php

namespace Tests\Unit;

use App\Services\FakeStoreProductImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FakeStoreProductImportServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_imports_products_and_ratings()
    {
        Http::fake([
            'fakestoreapi.com/products' => Http::response([
                [
                    'id' => 1,
                    'title' => 'Test Product',
                    'price' => 99.99,
                    'description' => 'Test desc',
                    'category' => 'test-category',
                    'image' => 'http://example.com/image.jpg',
                    'rating' => [
                        'rate' => 4.5,
                        'count' => 123,
                    ],
                ],
            ]),
        ]);

        $service = new FakeStoreProductImportService;
        $service->import();

        $this->assertDatabaseHas('products', [
            'external_id' => 1,
            'title' => 'Test Product',
        ]);

        $this->assertDatabaseHas('product_ratings', [
            'product_id' => 1,
            'rate' => 4.5,
        ]);
    }
}
