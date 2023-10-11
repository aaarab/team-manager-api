<?php

namespace App\Exceptions;
use Exception;

class InvalidDataException extends Exception {

    private $errors;

    public function render()
    {
        return response()->json($this->errors, 422);
    }

    public function withErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }
}
