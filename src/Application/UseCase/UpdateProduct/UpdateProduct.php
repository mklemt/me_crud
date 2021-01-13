<?php


namespace App\Application\UseCase\UpdateProduct;

use App\Application\CQRS\CommandInterface;

class UpdateProduct implements CommandInterface
{
    private string $uuid;
    private ?string $name;
    private ?int $lastStatus;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $nazwa
     */
    public function setName(string $nazwa): void
    {
        $this->name = $nazwa;
    }

    /**
     * @return int
     */
    public function getLastStatus(): int
    {
        return $this->lastStatus;
    }

    /**
     * @param int $lastStatus
     */
    public function setLastStatus(int $lastStatus): void
    {
        $this->lastStatus = $lastStatus;
    }


}