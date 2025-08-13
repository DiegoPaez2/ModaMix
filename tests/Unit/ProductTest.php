<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    /** @test */
    public function puede_crear_producto()
    {
        $product = new Product([
            'name' => 'Camisa',
            'price' => 25.99,
            'stock' => 10
        ]);
        $this->assertEquals('Camisa', $product->name);
        $this->assertEquals(25.99, $product->price);
        $this->assertEquals(10, $product->stock);
    }
}
