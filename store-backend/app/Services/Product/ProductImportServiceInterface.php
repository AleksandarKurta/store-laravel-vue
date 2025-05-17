<?php

namespace App\Services\Product;

interface ProductImportServiceInterface
{
    public function import(bool $fresh = false): array;
}
