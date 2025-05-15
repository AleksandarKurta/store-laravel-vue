<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductRatingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'rate' => $this->faker->randomFloat(1, 1, 5),
            'count' => $this->faker->numberBetween(1, 500),
        ];
    }
}
