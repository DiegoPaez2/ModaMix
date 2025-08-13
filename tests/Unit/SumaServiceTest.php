<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\SumaService;

class SumaServiceTest extends TestCase
{
    public function testSumaCorrecta()
    {
        $suma = new SumaService();
        $this->assertEquals(5, $suma->sumar(2, 3));
    }
}
