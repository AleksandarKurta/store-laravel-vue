<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CartFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'session_id' => Str::random(40),
            'cart_token' => $this->faker->uuid,
        ];
    }

    public function guest(): static
    {
        return $this->state(fn () => [
            'user_id' => null,
        ]);
    }
}
