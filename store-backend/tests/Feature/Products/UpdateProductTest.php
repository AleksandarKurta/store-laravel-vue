<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_update_product()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $product = Product::factory()->create([
            'title' => 'Old Title',
            'description' => 'Old description',
            'image' => 'http://example.com/old.jpg',
            'price' => 100.00,
        ]);

        $payload = [
            'title' => 'New Title',
            'description' => 'New description',
            'image' => 'http://example.com/new.jpg',
            'price' => 110.00,
        ];

        $response = $this->putJson("/api/update/product/{$product->id}", $payload);

        $response->assertOk()
            ->assertJson([
                'message' => 'Product updated successfully',
                'data' => [
                    'id' => $product->id,
                    'title' => 'New Title',
                    'description' => 'New description',
                    'image' => 'http://example.com/new.jpg',
                    'price' => 110.00,
                ],
            ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'New Title',
            'description' => 'New description',
            'image' => 'http://example.com/new.jpg',
            'price' => 110.00,
        ]);
    }

    public function test_guest_cannot_update_product()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/update/product/{$product->id}", [
            'title' => 'Test title',
            'description' => 'Test description',
            'image' => 'http://example.com/fake.jpg',
            'price' => 0,
        ]);

        $response->assertUnauthorized();
    }

    public function test_validation_fails_with_invalid_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $product = Product::factory()->create();

        $response = $this->putJson("/api/update/product/{$product->id}", [
            'title' => '',
            'description' => null,
            'image' => null,
            'price' => 'free',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title', 'description', 'image', 'price']);
    }
}
