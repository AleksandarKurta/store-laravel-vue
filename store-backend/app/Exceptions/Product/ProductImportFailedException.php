<?php

namespace App\Exceptions\Product;

use Exception;

class ProductImportFailedException extends Exception
{
    public function __construct(string $message = 'Product import failed.', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
