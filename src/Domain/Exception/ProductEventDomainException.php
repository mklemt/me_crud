<?php


namespace App\Domain\Exception;

use Exception;

class ProductEventDomainException extends Exception
{

    public static function objectIsNotValidType()
    {
        $message = sprintf("To nie jest prawidłowy typ obiektu");

        throw new self($message);
    }
}