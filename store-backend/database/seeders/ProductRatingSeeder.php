<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductRating;

class ProductRatingSeeder extends Seeder
{
    public function run(): void
    {
        Product::all()->each(function ($product) {
            ProductRating::factory()->create([
                'product_id' => $product->id,
            ]);
        });
    }
}
