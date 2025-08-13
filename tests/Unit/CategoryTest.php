<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    /** @test */
    public function puede_crear_categoria()
    {
        $category = new Category([
            'name' => 'Hombre'
        ]);
        $this->assertEquals('Hombre', $category->name);
    }
}
