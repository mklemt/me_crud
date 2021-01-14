<?php


namespace App\Application\UseCase\CreateProduct;

use App\Application\CQRS\CommandInterface;

class CreateProduct implements CommandInterface
{
    private string $name;
    private string $uuid;

    public function __construct(string $uuid, string $name)
    {
        $this->name = $name;
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }


}