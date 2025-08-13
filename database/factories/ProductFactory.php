<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipos = ['Camiseta', 'Pantalón', 'Vestido', 'Chaqueta', 'Zapatos', 'Blusa', 'Short', 'Falda', 'Abrigo', 'Sudadera', 'Jeans', 'Traje', 'Ropa deportiva', 'Ropa interior', 'Bufanda', 'Gorra'];
        $colores = ['Rojo', 'Azul', 'Negro', 'Blanco', 'Verde', 'Amarillo', 'Gris', 'Rosa', 'Morado', 'Marrón'];
        $tallas = ['S', 'M', 'L', 'XL', 'XXL'];
        $tipo = $this->faker->randomElement($tipos);
        $color = $this->faker->randomElement($colores);
        $talla = $this->faker->randomElement($tallas);
        $nombre = "$tipo $color Talla $talla";
        return [
            'name' => $nombre,
            'brief_description' => "{$tipo} de color {$color}, disponible en talla {$talla}.",
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 5, 500),
            'old_price' => $this->faker->randomFloat(2, 5, 700),
            'SKU' => $this->faker->unique()->bothify('SKU-####'),
            'stock_status' => $this->faker->randomElement(['instock', 'outstock']),
            'quantity' => $this->faker->numberBetween(1, 100),
            'image' => $this->faker->imageUrl(400, 400, 'fashion', true, $tipo),
            'images' => json_encode([
                $this->faker->imageUrl(400, 400, 'fashion', true, $tipo),
                $this->faker->imageUrl(400, 400, 'fashion', true, $tipo)
            ]),
        ];
    }
}
