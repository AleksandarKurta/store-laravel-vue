<?php

namespace App\Exceptions\Cart;

use Exception;

class CartNotFoundException extends Exception
{
    public function __construct(string $message = 'Cart update failed.', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
