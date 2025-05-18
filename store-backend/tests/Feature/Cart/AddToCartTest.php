<?php

namespace Tests\Feature\Cart;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AddToCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_to_cart_successfully(): void
    {
        $product = Product::factory()->create();

        $response = $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
            'cart_token' => Str::uuid()->toString(),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Added to cart successfully',
            ]);
    }

    public function test_add_to_cart_validation_fails_with_invalid_data(): void
    {
        $response = $this->postJson(route('cart.add'), [
            'product_id' => 9999,
            'quantity' => 0,
            'cart_token' => 'invalid-uuid',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id', 'quantity', 'cart_token']);
    }

    public function test_add_to_cart_fails_when_product_does_not_exist(): void
    {
        $response = $this->postJson(route('cart.add'), [
            'product_id' => 9999,
            'quantity' => 1,
            'cart_token' => Str::uuid()->toString(),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id']);
    }

    public function test_add_to_cart_fails_with_missing_fields(): void
    {
        $response = $this->postJson(route('cart.add'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id', 'quantity', 'cart_token']);
    }

    public function test_add_to_cart_fails_with_invalid_quantity(): void
    {
        $product = Product::factory()->create();

        $response = $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 0,
            'cart_token' => Str::uuid()->toString(),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['quantity']);
    }
}
