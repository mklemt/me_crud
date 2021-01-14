<?php


namespace App\Application\UseCase\ListAllProducts;

use App\Application\CQRS\QueryHandlerInterface;
use App\Domain\Model\Product\ProductFinderInterface;

class ListAllProductsHandler implements QueryHandlerInterface
{
    /**
     * @var ProductFinderInterface
     */
    private ProductFinderInterface $productFinder;

    public function __construct(ProductFinderInterface $productFinder)
    {
        $this->productFinder = $productFinder;
    }

    public function __invoke(ListAllProductsQuery $query)
    {
        dd($query);
    }

}