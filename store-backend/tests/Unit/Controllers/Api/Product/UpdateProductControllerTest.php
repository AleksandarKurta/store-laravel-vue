<?php

namespace Tests\Feature\Controllers\Api\Product;

use App\Models\Product;
use App\Models\User;
use App\Services\Product\ProductUpdaterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function it_updates_a_product_successfully()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $product = Product::factory()->create();

        $payload = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'image' => 'http://example.com/updated-image.jpg',
            'price' => 99.99,
        ];

        $response = $this->putJson(route('product.update', $product), $payload);

        $response->assertOk()
            ->assertJsonStructure([
                'message',
                'product' => [
                    'id',
                    'title',
                    'description',
                    'image',
                    'price',
                    'category',
                ],
            ])
            ->assertJson([
                'message' => 'Product updated successfully',
                'product' => [
                    'title' => 'Updated Title',
                    'description' => 'Updated Description',
                    'image' => 'http://example.com/updated-image.jpg',
                    'price' => '99.99',
                ],
            ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);
    }

    public function it_returns_error_if_update_fails()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $product = Product::factory()->create();

        $this->mock(
            ProductUpdaterService::class,
            function ($mock) use ($product) {
                $mock->shouldReceive('update')
                    ->once()
                    ->with($product, \Mockery::any())
                    ->andThrow(new \App\Exceptions\Product\ProductUpdateFailedException('Update failed'));
            }
        );

        $payload = [
            'title' => 'New Title',
            'description' => 'New Description',
            'image' => 'image.jpg',
            'price' => 10.00,
        ];

        $response = $this->putJson(route('product.update', $product), $payload);

        $response->assertStatus(500)
            ->assertJson([
                'message' => 'Update failed',
            ]);
    }
}
