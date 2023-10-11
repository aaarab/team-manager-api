<?php

namespace App\Exceptions;

use Exception;

class InvalidTokenException extends Exception
{
    public function render()
    {
        return response()->json('Invalid Token', 401);
    }
}
