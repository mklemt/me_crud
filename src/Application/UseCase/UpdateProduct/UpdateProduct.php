<?php


namespace App\Application\UseCase\UpdateProduct;


class UpdateProduct
{
    private string $uuid;
    private string $nazwa;
    private string $lastStatus;
    private string $createdAt;

    public function __construct(string $uuid, string $nazwa, string $lastStatus, string $createdAt)
    {
        $this->uuid = $uuid;
        $this->nazwa = $nazwa;
        $this->lastStatus = $lastStatus;
        $this->createdAt = $createdAt;
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

    /**
     * @return string
     */
    public function getNazwa(): string
    {
        return $this->nazwa;
    }

    /**
     * @param string $nazwa
     */
    public function setNazwa(string $nazwa): void
    {
        $this->nazwa = $nazwa;
    }

    /**
     * @return string
     */
    public function getLastStatus(): string
    {
        return $this->lastStatus;
    }

    /**
     * @param string $lastStatus
     */
    public function setLastStatus(string $lastStatus): void
    {
        $this->lastStatus = $lastStatus;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }


}