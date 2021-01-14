<?php


namespace App\Application\UseCase\DeleteProduct;

use App\Application\CQRS\CommandHandlerInterface;
use App\Domain\Model\Product\ProductPersistanceRepositoryInterface;

class DeleteProductHandler implements CommandHandlerInterface
{
    /**
     * @var ProductPersistanceRepositoryInterface
     */
    private ProductPersistanceRepositoryInterface $productRepository;

    public function __construct(ProductPersistanceRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(DeleteProduct $command)
    {
        $this->productRepository->delete($command->getUuid());
    }

}