<?php


namespace App\Domain\Exception;

use Exception;

class IdentifierDomainException extends Exception
{

    public static function badFormatOfUUID()
    {
        $message = sprintf("Nieprawidłowy format podanego identyfikatora");

        throw new self($message);
    }
}