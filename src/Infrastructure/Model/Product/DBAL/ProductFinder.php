<?php


namespace App\Infrastructure\Model\Product\DBAL;

use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductFinderInterface;
use App\Domain\Model\ProductEvent\ProductEvent;

class ProductFinder implements ProductFinderInterface
{

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
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