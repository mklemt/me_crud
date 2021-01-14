<?php


namespace App\Application\UseCase\ListEvents;

use App\Application\CQRS\QueryHandlerInterface;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductFinderInterface;

class ListEventsHandler implements QueryHandlerInterface
{
    /**
     * @var ProductFinderInterface
     */
    private ProductFinderInterface $productFinder;

    public function __construct(ProductFinderInterface $productFinder)
    {
        $this->productFinder = $productFinder;
    }

    public function __invoke(ListEventsQuery $query)
    {
        $product = $this->productFinder->findByIdentifier($query->getProductId());

        /** @var Product $product */
        return $product->toArray();

    }
}