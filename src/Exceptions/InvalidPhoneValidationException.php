<?php
namespace App\Exceptions;

class InvalidPhoneValidationException extends ValidationException
{

    /**
     * InvalidPhoneValidationException constructor.
     * @param string $string
     */
    public function __construct(string $string)
    {
    }
}