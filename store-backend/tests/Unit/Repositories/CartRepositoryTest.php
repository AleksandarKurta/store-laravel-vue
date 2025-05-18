<?php

namespace Tests\Unit\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Cart\CartRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CartRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected CartRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new CartRepository;
    }

    public function test_it_creates_cart_if_not_exists()
    {
        $user = User::factory()->create();
        $cartToken = Str::uuid()->toString();
        $sessionId = session()->getId();

        $cart = $this->repository->findOrCreateCart($user->id, $cartToken, $sessionId);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'cart_token' => $cartToken,
            'session_id' => $sessionId,
        ]);

        $this->assertInstanceOf(Cart::class, $cart);
    }

    public function test_it_finds_existing_cart()
    {
        $user = User::factory()->create();
        $cartToken = Str::uuid()->toString();
        $sessionId = 'test-session-id';

        Cart::factory()->create([
            'user_id' => $user->id,
            'cart_token' => $cartToken,
            'session_id' => $sessionId,
        ]);

        $cart = $this->repository->findOrCreateCart($user->id, $cartToken, 'new-session');

        $this->assertEquals($sessionId, $cart->session_id); // Should not overwrite
    }

    public function test_it_adds_new_cart_item()
    {
        $cart = Cart::factory()->create();
        $product = Product::factory()->create();

        $this->repository->addOrUpdateCartItem($cart, $product->id, 2);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_it_updates_existing_cart_item_quantity()
    {
        $cart = Cart::factory()->create();
        $product = Product::factory()->create();

        $item = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->repository->addOrUpdateCartItem($cart, $product->id, 3);

        $this->assertEquals(4, $item->fresh()->quantity);
    }
}
