<?php

namespace Tests\Feature\Products;

use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class FetchProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_products_returns_expected_structure()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson(route('products.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'message',
                'products' => [
                    '*' => ['id', 'title', 'price', 'image', 'category'],
                ],
            ])
            ->assertJson(['message' => 'Products fetched successfully']);
    }

    public function test_fetch_products_uses_cache()
    {
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn(Product::factory()->count(3)->make());

        $this->getJson(route('products.index'));
    }

    public function test_product_resource_formatting()
    {
        $product = Product::factory()->create([
            'price' => 49,
        ]);

        $resource = (new ProductResource($product))->toArray(request());

        $this->assertEquals('49.00', $resource['price']);
    }
}
