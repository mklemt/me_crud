<?php


namespace App\Application\UseCase\FilterProduct;

use App\Application\CQRS\QueryInterface;

class FilterProductQuery implements QueryInterface
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

}