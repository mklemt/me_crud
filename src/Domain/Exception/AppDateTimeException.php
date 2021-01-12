<?php


namespace App\Domain\Exception;

use Exception;

class AppDateTimeException extends Exception
{

    public static function notValidDateFormatString()
    {
        $message = sprintf("Nieprawidłowy format daty");

        throw new self($message);
    }
}