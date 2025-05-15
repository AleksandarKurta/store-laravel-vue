<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'external_id' => $this->faker->unique()->numberBetween(1000, 9999),
            'title' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'description' => $this->faker->paragraph,
            'category' => $this->faker->randomElement(['electronics', 'fashion', 'books', 'home', 'beauty']),
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
        ];
    }
}
