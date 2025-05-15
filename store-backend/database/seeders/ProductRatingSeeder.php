<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Database\Seeder;

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
