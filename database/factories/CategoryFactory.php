<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Aretes',
            'Collares',
            'Pulseras',
            'Anillos',
            'Sets',
            'Temporada',
            'Edición Limitada',
        ]);
        $slug = Str::slug($name);

        if ($slug === '') {
            $slug = Str::random(8);
        }

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->randomElement([
                'Colección seleccionada para tienda de joyería.',
                'Productos con acabados premium para uso diario.',
                'Línea pensada para regalo y ocasiones especiales.',
            ]),
        ];
    }
}
