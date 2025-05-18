<?php

namespace Tests\Feature\Http\Controllers\Api\Cart;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AddToCartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_adds_product_to_cart_successfully(): void
    {
        $product = Product::factory()->create();
        $uuid = Str::uuid()->toString();

        $response = $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
            'cart_token' => $uuid,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Added to cart successfully',
            ]);

        $this->assertDatabaseHas('carts', [
            'cart_token' => $uuid,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_fails_with_invalid_product_id(): void
    {
        $uuid = Str::uuid()->toString();

        $response = $this->postJson(route('cart.add'), [
            'product_id' => 9999,
            'quantity' => 2,
            'cart_token' => $uuid,
        ]);

        $response->assertStatus(422);
    }

    public function test_fails_with_invalid_cart_token_format(): void
    {
        $product = Product::factory()->create();

        $response = $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
            'cart_token' => 'invalid-token',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('cart_token');
    }

    public function test_updates_existing_cart_item_quantity(): void
    {
        $product = Product::factory()->create();
        $uuid = Str::uuid()->toString();

        $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
            'cart_token' => $uuid,
        ]);

        $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
            'cart_token' => $uuid,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
    }
}
