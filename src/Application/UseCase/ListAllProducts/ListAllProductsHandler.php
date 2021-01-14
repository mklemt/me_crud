<?php


namespace App\Application\UseCase\ListAllProducts;

use App\Application\CQRS\QueryHandlerInterface;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductQueryRepositoryInterface;

class ListAllProductsHandler implements QueryHandlerInterface
{
    /**
     * @var ProductQueryRepositoryInterface
     */
    private ProductQueryRepositoryInterface $productFinder;

    public function __construct(ProductQueryRepositoryInterface $productFinder)
    {
        $this->productFinder = $productFinder;
    }

    public function __invoke(ListAllProductsQuery $query)
    {
        $result   = [];
        $products = $this->productFinder->findAll();
        /** @var Product $product */
        foreach ($products as $product) {
            $result[] = $product->toArray();
        }

        return $result;

    }

}