<?php

namespace App\Services;

interface ProductImportServiceInterface
{
    public function import(bool $fresh = false): array;
}
