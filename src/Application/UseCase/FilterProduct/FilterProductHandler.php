<?php


namespace App\Application\UseCase\FilterProduct;

use App\Application\CQRS\QueryHandlerInterface;

class FilterProductHandler implements QueryHandlerInterface
{
    public function __invoke(FilterProductQuery $query)
    {
        return [];
    }

}