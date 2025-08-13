<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Order;
use App\Models\OrderItem;

class OrderTest extends TestCase
{
    /** @test */
    public function calcula_subtotal_correctamente()
    {
        $order = new Order();
        $item1 = new OrderItem(['price' => 10, 'quantity' => 2]);
        $item2 = new OrderItem(['price' => 5, 'quantity' => 3]);
        $order->setRelation('orderItems', collect([$item1, $item2]));

        $this->assertEquals(10*2 + 5*3, $order->subtotal);
    }
}
