<?php


namespace App\Application\UseCase\UpdateProduct;

use App\Application\CQRS\CommandHandlerInterface;
use App\Domain\Model\ProductName;
use App\Domain\Model\Status;
use App\Domain\Service\ProductService;

class UpdateProductHandler implements CommandHandlerInterface
{
    /**
     * @var ProductService
     */
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke(UpdateProduct $command)
    {
        $product = $this->productService->getProduct($command->getUuid());
        if (empty($product)) {
            return;
        }
        if ( ! empty($command->getName())) {
            $productName = ProductName::create($command->getName());
            $product->setName($productName);
        }
        if ( ! empty($command->getLastStatus())) {
            $lastStatus = Status::create($command->getLastStatus());
            $product->setLastStatus($lastStatus->status());
        }
        $this->productService->save($product);

    }
}