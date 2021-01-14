<?php


namespace App\Application\UseCase\CreateProduct;

use App\Application\CQRS\CommandHandlerInterface;
use App\Domain\Model\Product\Product;
use App\Domain\Model\ProductName;
use App\Domain\Service\ProductService;

class CreateProductHandler implements CommandHandlerInterface
{
    /**
     * @var ProductService
     */
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke(CreateProduct $command)
    {
        $productName = ProductName::create($command->getName());
        $product     = Product::create($command->getUuid(), $productName);
        if (empty($product)) {
            return;
        }
        $this->productService->save($product);
    }

}