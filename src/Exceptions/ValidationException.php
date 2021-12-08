<?php
namespace App\Exceptions;
use Exception;
use Throwable;

class ValidationException extends Exception
{
    public function __construct($message = "Error de validació", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}