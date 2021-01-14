<?php


namespace App\Application\UseCase\DeleteProduct;

use App\Application\CQRS\CommandHandlerInterface;
use App\Domain\Model\Product\ProductRepositoryInterface;

class DeleteProductHandler implements CommandHandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(DeleteProduct $command)
    {
        $this->productRepository->delete($command->getUuid());
    }

}