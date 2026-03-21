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
        $name = fake()->unique()->words(fake()->numberBetween(2, 4), true);
        $slug = Str::slug($name);

        if ($slug === '') {
            $slug = Str::random(8);
        }

        return [
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'name' => Str::title($name),
            'slug' => $slug,
            'description' => fake()->optional(0.85)->paragraphs(2, true),
            'price' => fake()->randomFloat(2, 79, 1299),
            'stock' => fake()->boolean(85),
            'material' => fake()->optional(0.7)->randomElement(['Plata', 'Acero', 'Oro', 'Chapa de oro', 'Piedra natural']),
            'color' => fake()->optional(0.6)->randomElement(['Dorado', 'Plateado', 'Negro', 'Perla', 'Ámbar']),
            'is_active' => fake()->boolean(92),
        ];
    }
}

