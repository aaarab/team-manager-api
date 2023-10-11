<?php

namespace App\Exceptions;

use Exception;

class MissingTokenException extends Exception
{
    public function render()
    {
        return response()->json('Missing Token', 401);
    }
}
