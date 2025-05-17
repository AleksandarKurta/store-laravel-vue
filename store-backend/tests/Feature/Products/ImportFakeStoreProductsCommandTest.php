<?php

namespace Tests\Feature\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ImportFakeStoreProductsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_imports_products()
    {
        Http::fake([
            'fakestoreapi.com/products' => Http::response([
                [
                    'id' => 10,
                    'title' => 'CLI Product',
                    'price' => 19.99,
                    'description' => 'Via CLI',
                    'category' => 'cli-category',
                    'image' => 'http://example.com/img.jpg',
                    'rating' => [
                        'rate' => 4.9,
                        'count' => 200,
                    ],
                ],
            ]),
        ]);

        $this->artisan('import:fake-store-products')
            ->expectsOutput('Import completed successfully.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('products', [
            'external_id' => 10,
            'title' => 'CLI Product',
        ]);

        $this->assertDatabaseHas('product_ratings', [
            'rate' => 4.9,
            'count' => 200,
        ]);
    }

    public function test_command_with_fresh_deletes_old_data()
    {
        Http::fake([
            'fakestoreapi.com/products' => Http::response([]),
        ]);

        $this->artisan('import:fake-store-products --fresh')
            ->assertExitCode(0);

        $this->assertDatabaseCount('products', 0);
        $this->assertDatabaseCount('product_ratings', 0);
    }
}
