<?php


namespace App\Application\UseCase\ListAllProducts;

use App\Application\CQRS\QueryHandlerInterface;
use App\Domain\Service\ProductService;

class ListAllProductsHandler implements QueryHandlerInterface
{
    /**
     * @var ProductService
     */
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke(ListAllProductsQuery $query)
    {
        $products = $this->productService->findAll();
        return $products;
    }

}