<?php


namespace App\Infrastructure\Model\Product\DBAL;

use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductFinderInterface;
use App\Domain\Model\ProductEvent\ProductEvent;
use Doctrine\ORM\EntityManagerInterface;

class ProductFinder implements ProductFinderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll(): array
    {
        $productRepository = $this->entityManager->getRepository(Product::class);
        $products          = $productRepository->findAll();

        return $products;

    }

    public function findByIdentifier(string $uuid): ?Product
    {
        // TODO: Implement findByIdentifier() method.
    }

    public function findByName(string $name): array
    {
        // TODO: Implement findByName() method.
    }

    public function findByLastStatus(int $status): array
    {
        // TODO: Implement findByLastStatus() method.
    }

    public function findByCreatedDate(string $createdDate): array
    {
        // TODO: Implement findByCreatedDate() method.
    }

    public function findByEvent(ProductEvent $productEvent): array
    {
        // TODO: Implement findByEvent() method.
    }
}