<?php

namespace App\Repositories;

use App\DTOs\ProductDTO;
use App\Models\Product;

interface ProductRepositoryInterface
{
    public function save(ProductDTO $dto): Product;
}
