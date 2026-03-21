<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Arete Mini Perla',
            'Arete Argolla Dorada',
            'Collar Inicial',
            'Collar Luna Fina',
            'Pulsera Eslabón',
            'Pulsera Ojo Turco',
            'Anillo Ajustable',
            'Anillo Nudo',
            'Set Elegancia',
            'Colección Primavera',
        ]);
        $slug = Str::slug($name.' '.$this->faker->unique()->numberBetween(100, 999));

        if ($slug === '') {
            $slug = Str::random(8);
        }

        return [
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->randomElement([
                'Pieza versátil para uso diario con acabado brillante.',
                'Diseño elegante para eventos y regalos especiales.',
                'Modelo ligero y cómodo con excelente relación calidad-precio.',
            ]),
            'price' => $this->faker->randomFloat(2, 149, 799),
            'stock' => $this->faker->boolean(85),
            'material' => $this->faker->optional(0.8)->randomElement(['Plata .925', 'Acero inoxidable', 'Chapa de oro', 'Perla natural', 'Acero y cristal']),
            'color' => $this->faker->optional(0.8)->randomElement(['Dorado', 'Plateado', 'Rose Gold', 'Perla', 'Ámbar', 'Turquesa']),
            'is_active' => $this->faker->boolean(92),
        ];
    }
}
