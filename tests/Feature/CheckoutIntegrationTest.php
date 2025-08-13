<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_puede_realizar_checkout_y_ver_factura()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 20]);

        $this->actingAs($user)
            ->post('/cart/add', [
                'product_id' => $product->id,
                'quantity' => 2
            ]);

        $response = $this->actingAs($user)
            ->post('/checkout/order', [
                'billing_address' => 'Av. Principal 123',
                'phone' => '0999999999',
                'payment_method' => 'efectivo'
            ]);

        $response->assertRedirect('/checkout/confirmation');

        $order = Order::where('user_id', $user->id)->first();
        $this->assertNotNull($order);
        $this->assertEquals(40, $order->subtotal);

        $facturaResponse = $this->actingAs($user)
            ->get(route('invoice', $order));
        $facturaResponse->assertStatus(200);
        $facturaResponse->assertSee('Factura Electrónica');
    }
}
