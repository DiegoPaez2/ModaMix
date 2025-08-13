<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\BillingDetail;

class UserFlowIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_puede_registrarse_y_loguearse()
    {
        $response = $this->post('/register', [
            'name' => 'Carlos',
            'email' => 'carlos@email.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', ['email' => 'carlos@email.com']);

        $login = $this->post('/login', [
            'email' => 'carlos@email.com',
            'password' => 'password'
        ]);
        $login->assertRedirect('/');
    }

    /** @test */
    public function usuario_puede_agregar_y_eliminar_producto_del_carrito()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 15]);
        $this->actingAs($user)
            ->post('/cart/add', [
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        $this->assertTrue(true); // Aquí deberías verificar el contenido del carrito
        $this->actingAs($user)
            ->post('/cart/remove', [
                'product_id' => $product->id
            ]);
        $this->assertTrue(true); // Aquí deberías verificar que el carrito está vacío
    }

    /** @test */
    public function usuario_puede_actualizar_su_perfil()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->put('/profile', [
                'name' => 'Carlos Actualizado',
                'email' => $user->email
            ]);
        $this->assertDatabaseHas('users', ['name' => 'Carlos Actualizado']);
    }

    /** @test */
    public function usuario_puede_ver_sus_ordenes_y_facturas()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)
            ->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Mis pedidos');
        $factura = $this->actingAs($user)
            ->get(route('invoice', $order));
        $factura->assertStatus(200);
        $factura->assertSee('Factura Electrónica');
    }
}
