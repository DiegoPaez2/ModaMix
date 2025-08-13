<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\OrderItem;

class OrderItemTest extends TestCase
{
    /** @test */
    public function calcula_subtotal_item()
    {
        $item = new OrderItem([
            'price' => 15,
            'quantity' => 2
        ]);
        $subtotal = $item->price * $item->quantity;
        $this->assertEquals(30, $subtotal);
    }
}
