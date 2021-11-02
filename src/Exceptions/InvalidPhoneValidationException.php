<?php


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