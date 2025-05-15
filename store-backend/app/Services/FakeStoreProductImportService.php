<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use App\Exceptions\Product\ProductImportFailedException;
use App\Models\Product;
use App\Models\ProductRating;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\Http;

class FakeStoreProductImportService implements ProductImportServiceInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    ) {}

    public function import(bool $fresh = false): array
    {
        if ($fresh) {
            ProductRating::query()->delete();
            Product::query()->delete();
        }

        $response = Http::get('https://fakestoreapi.com/products');

        if ($response->failed()) {
            throw new ProductImportFailedException('Failed to fetch products from Fake Store API.');
        }

        $imported = [];

        foreach ($response->json() as $apiProduct) {
            $dto = ProductDTO::fromArray($apiProduct);

            $product = $this->productRepository->save($dto);

            $imported[] = $product->title;
        }

        return $imported;
    }
}
