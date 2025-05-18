<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class FetchProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_paginated_products_response()
    {
        Product::factory()->count(30)->create();

        $response = $this->getJson(route('products.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'message',
                'products' => [
                    '*' => ['id', 'title', 'price', 'image', 'category'],
                ],
            ])
            ->assertJsonFragment([
                'message' => 'Products fetched successfully',
            ]);
    }
}
