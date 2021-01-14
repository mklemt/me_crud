<?php


namespace App\Infrastructure\Service;


use Throwable;

class ResponseStatus
{
    const UPDATED = 'updated';
    const NOTUPDATED = 'not updated';

    public function ok()
    {
        return self::UPDATED;
    }

    public function error(Throwable $exception)
    {
        return sprintf("%s, message: %s", self::NOTUPDATED, $exception->getMessage());
    }

    public function nothingToDo()
    {
        return self::NOTUPDATED;
    }

}