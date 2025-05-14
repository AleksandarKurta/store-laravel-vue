<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Support\Facades\Http;

class FakeStoreProductImportService implements ProductImportServiceInterface
{
    public function import(bool $fresh = false): array
    {
        if ($fresh) {
            ProductRating::query()->delete();
            Product::query()->delete();
        }

        $response = Http::get('https://fakestoreapi.com/products');

        if ($response->failed()) {
            throw new \Exception('Failed to fetch products from API');
        }

        $imported = [];

        foreach ($response->json() as $apiProduct) {
            $product = Product::updateOrCreate(
                ['external_id' => $apiProduct['id']],
                [
                    'title' => $apiProduct['title'],
                    'price' => $apiProduct['price'],
                    'description' => $apiProduct['description'],
                    'category' => $apiProduct['category'],
                    'image' => $apiProduct['image'],
                    'synced_at' => now(),
                ]
            );

            $product->rating()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'rate' => $apiProduct['rating']['rate'],
                    'count' => $apiProduct['rating']['count'],
                ]
            );

            $imported[] = $product->title;
        }

        return $imported;
    }
}
