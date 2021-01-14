<?php


namespace App\Domain\Model;

use App\Domain\Exception\StatusDomainException;

final class Status
{
    const CREATED = 10;
    const REMOVED = 40;
    const UPDATED = 30;
    const WORKING = 20;
    private static $statuses = [];
    private int $status;

    private function __construct(int $status)
    {
        $this->status = $status;
    }

    public static function create(int $status): self
    {
        self::translateStatuses();

        self::validate($status);

        return new self($status);
    }

    private static function validate(int $status): void
    {
        if ( ! array_key_exists($status, self::$statuses)) {
            StatusDomainException::noSuchStatus($status);
        }
    }

    private static function translateStatuses(): void
    {
        self::$statuses[self::CREATED] = "Utworzony";
        self::$statuses[self::REMOVED] = "Usunięty";
        self::$statuses[self::UPDATED] = "Zauktualizowny";
        self::$statuses[self::WORKING] = "Zajęty";
    }

    public function statusAsString()
    {
        self::translateStatuses();
        return self::$statuses[$this->status];
    }

    public function status()
    {
        return $this->status;

    }

    public function getAllStatuses()
    {
        return self::$statuses;
    }

    public function equal(Status $status)
    {
        return $this->status == $status->status();

    }
}