<?php

namespace App\Http\Middleware;

use App\Exceptions\InvalidTokenException;
use App\Exceptions\MissingTokenException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request)
    {
        if($request->header('authorization') === "") {
            throw new InvalidTokenException();
        }

        if (!isset($request->header('authorization')[0])) {
            throw new MissingTokenException();
        }
    }
}
