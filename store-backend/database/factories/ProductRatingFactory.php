<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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
