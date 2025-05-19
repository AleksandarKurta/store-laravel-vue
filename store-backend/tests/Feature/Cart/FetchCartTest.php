<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class FetchCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_fetches_cart_by_token()
    {
        $product = Product::factory()->create(['price' => 10.00]);

        $cart = Cart::factory()->create([
            'cart_token' => $token = \Str::uuid()->toString(),
        ]);

        CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response = $this->getJson(route('cart.get', ['cart_token' => $token]));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'cart_token' => $token,
                'total_quantity' => 3,
                'total_price' => 30.00,
            ],
            'message' => 'Cart fetched successfully',
        ]);
    }

    public function test_it_returns_empty_cart_response_if_not_found()
    {
        $nonExistentToken = \Str::uuid()->toString();

        $response = $this->getJson(route('cart.get', ['cart_token' => $nonExistentToken]));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Cart is empty',
        ]);
    }
}
