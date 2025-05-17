<?php

namespace App\Exceptions\Product;

use Exception;

class ProductUpdateFailedException extends Exception
{
    public function __construct(string $message = 'Failed to update the product.', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
