<?php

namespace App\Services\Product;

use App\DTOs\Product\ProductUpdateDTO;
use App\Models\Product;

interface ProductUpdaterServiceInterface
{
    public function update(Product $product, ProductUpdateDTO $dto): Product;
}
