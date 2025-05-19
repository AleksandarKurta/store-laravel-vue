<?php

namespace App\Services\Product;

use App\DTOs\Product\ProductDTO;
use App\Exceptions\Product\ProductImportFailedException;
use App\Models\Product;
use App\Models\ProductRating;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
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

        try {
            DB::beginTransaction();

            foreach ($response->json() as $apiProduct) {
                $dto = ProductDTO::fromArray($apiProduct);

                $product = $this->productRepository->saveProduct($dto);

                $this->productRepository->saveRating($product->id, $dto->rating);

                $imported[] = $product->title;
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw new ProductImportFailedException('Failed to import product and rating.');
        }

        return $imported;
    }
}
