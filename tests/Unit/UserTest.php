<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /** @test */
    public function puede_crear_usuario()
    {
        $user = new User([
            'name' => 'Ana',
            'email' => 'ana@email.com',
        ]);
        $this->assertEquals('Ana', $user->name);
        $this->assertEquals('ana@email.com', $user->email);
    }
}
