<?php


namespace App\Domain\Exception;

use Exception;

class ProductDomainException extends Exception
{
    public static function productExistWithIdentifier(string $identifier)
    {
        $message = sprintf("Produkt o identyfikatorze %s istnieje w repozytorium", $identifier);

        throw new self($message);
    }

    public static function productNotExist()
    {
        $message = sprintf("Produkt nie istnieje w repozytorium");

        throw new self($message);
    }

}