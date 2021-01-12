<?php


namespace App\Domain\Exception;

use Exception;

class StatusDomainException extends Exception
{
    public static function noSuchStatus(int $status)
    {
        $message = sprintf("Podany status: %s nie istnieje w systemie", $status);

        throw new self($message);
    }

    public static function productAlreadyHasCreatedStatus()
    {
        $message = sprintf("Product posiada już status utworzony");

        throw new self($message);
    }
}