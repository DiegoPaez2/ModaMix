<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear categorías y productos
        Category::factory(6)->create();
        $categories = Category::all();
        Product::factory(30)->create()->each(function ($product) use ($categories) {
            $product->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        // Usuarios administradores
        User::factory()->create([
            'name' => 'Admin Principal',
            'email' => 'admin@modamix.com',
            'password' => bcrypt('admin123'),
            'is_admin' => true
        ]);
        User::factory()->create([
            'name' => 'yusuf',
            'email' => 'yusuf@isawi.com',
            'password' => bcrypt('password'),
            'is_admin' => true
        ]);

        // Usuarios clientes
        User::factory()->create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@modamix.com',
            'password' => bcrypt('cliente123'),
            'is_admin' => false
        ]);
        User::factory(5)->create();
    }
}
