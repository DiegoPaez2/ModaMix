<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\BillingDetail;

class FunctionalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pagina_principal_se_carga_correctamente()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('ModaMix');
    }

    /** @test */
    public function usuario_puede_ver_catalogo_de_productos()
    {
        Product::factory()->count(3)->create();
        $response = $this->get('/productos');
        $response->assertStatus(200);
        $response->assertSee('Catálogo');
    }

    /** @test */
    public function usuario_puede_ver_detalle_de_producto()
    {
        $product = Product::factory()->create(['name' => 'Camisa']);
        $response = $this->get('/productos/' . $product->id);
        $response->assertStatus(200);
        $response->assertSee('Camisa');
    }

    /** @test */
    public function usuario_puede_acceder_al_carrito()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/cart');
        $response->assertStatus(200);
        $response->assertSee('Carrito');
    }

    /** @test */
    public function usuario_puede_acceder_al_checkout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/checkout');
        $response->assertStatus(200);
        $response->assertSee('Checkout');
    }

    /** @test */
    public function usuario_puede_ver_dashboard_de_ordenes()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Mis pedidos');
    }
}
