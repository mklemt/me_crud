<?php


namespace App\Application\UseCase\UpdateProduct;

use App\Application\CQRS\CommandInterface;
use App\Domain\Model\Status;

class UpdateProduct implements CommandInterface
{
    private string $uuid;
    private ?string $name;

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
    public function getName(): ?string
    {
        if ( ! empty($this->name)) {
            return $this->name;
        }

        return null;
    }

    /**
     * @param string $nazwa
     */
    public function setName(string $nazwa): void
    {
        $this->name = $nazwa;
    }

}