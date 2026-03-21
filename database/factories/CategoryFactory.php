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
        $name = fake()->unique()->words(fake()->numberBetween(1, 2), true);
        $slug = Str::slug($name);

        if ($slug === '') {
            $slug = Str::random(8);
        }

        return [
            'name' => Str::title($name),
            'slug' => $slug,
            'description' => fake()->optional(0.7)->sentence(10),
        ];
    }
}

