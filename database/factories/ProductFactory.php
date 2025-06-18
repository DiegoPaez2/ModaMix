<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        // Crear una instancia de Faker en español
        $faker = \Faker\Factory::create('es_ES');

        return [
            'name' => $faker->unique()->words(3, true), // Ej: "Zapatos deportivos negros"
            'brief_description' => $faker->sentence,     // Ej: "Una prenda cómoda y versátil."
            'description' => $faker->paragraph,          // Ej: "Esta prenda es ideal para..."
            'price' => $faker->randomFloat(2, 1, 1000),
            'old_price' => $faker->randomFloat(2, 1, 1000),
            'SKU' => $faker->unique()->bothify('SKU-####'),
            'stock_status' => $faker->randomElement(['en stock', 'agotado']),
            'quantity' => $faker->numberBetween(1, 100),
            'image' => $faker->imageUrl(),
            'images' => json_encode([$faker->imageUrl(), $faker->imageUrl()]),
        ];
    }
}
