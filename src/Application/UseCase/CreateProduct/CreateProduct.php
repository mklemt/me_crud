<?php


namespace App\Application\UseCase\CreateProduct;


class CreateProduct
{
    private string $nazwa;

    public function __construct(string $nazwa)
    {
        $this->nazwa = $nazwa;
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


}