<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\BillingDetail;

class BillingDetailTest extends TestCase
{
    /** @test */
    public function puede_crear_detalle_facturacion()
    {
        $billing = new BillingDetail([
            'billing_address' => 'Av. Principal 123',
            'phone' => '0999999999'
        ]);
        $this->assertEquals('Av. Principal 123', $billing->billing_address);
        $this->assertEquals('0999999999', $billing->phone);
    }
}
