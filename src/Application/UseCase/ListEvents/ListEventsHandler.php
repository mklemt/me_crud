<?php


namespace App\Application\UseCase\ListEvents;

use App\Application\CQRS\QueryHandlerInterface;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductQueryRepositoryInterface;

class ListEventsHandler implements QueryHandlerInterface
{
    /**
     * @var ProductQueryRepositoryInterface
     */
    private ProductQueryRepositoryInterface $productFinder;

    public function __construct(ProductQueryRepositoryInterface $productFinder)
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