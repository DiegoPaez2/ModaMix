<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        // Faker en español
        $faker = \Faker\Factory::create('es_ES');

        // Categorías personalizadas en español
        $categorias = [
            'Hombres', 'Mujeres', 'Niños', 'Ofertas', 'Zapatos', 'Accesorios',
            'Tecnología', 'Belleza', 'Deportes', 'Hogar', 'Juguetes', 'Ropa'
        ];

        $cat_name = $faker->unique()->randomElement($categorias);
        $cat_slug = Str::slug($cat_name);

        return [
            'name' => $cat_name,
            'slug' => $cat_slug,
        ];
    }
}
