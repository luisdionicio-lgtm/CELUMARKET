<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function createProduct(): Product
    {
        return Product::create([
            'name' => 'Producto de prueba',
            'precio' => 100,
            'price' => 100,
            'in_stock' => true,
        ]);
    }

    public function test_checkout_redirects_when_cart_empty(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('checkout.show'))
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('status', 'Tu carrito está vacío.');
    }

    public function test_user_payment_creates_order_and_clears_cart(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        $cartService = app(CartService::class);
        $cartService->addProduct($product, 2, $user);

        $response = $this->actingAs($user)->post(route('checkout.process'), [
            'method' => 'card',
            'card_number' => '4111111111111111',
            'expiry' => '12/30',
            'cvv' => '123',
        ]);

        $response->assertRedirect(route('cart.index'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method' => 'card',
            'simulated' => false,
        ]);

        $order = Order::first();
        $this->assertEquals(200, (int) $order->total);
        $this->assertDatabaseCount('order_items', 1);
        $this->assertDatabaseMissing('carts', ['user_id' => $user->id]);
    }

    public function test_session_cart_merges_on_login_event(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        session(['cart' => [$product->id => 3]]);

        event(new Login('web', $user, false));

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $this->assertEmpty(session('cart', []));
    }
}
