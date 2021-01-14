<?php


namespace App\Domain\Model\Product;

use App\Domain\Model\ProductEvent\ProductEvent;

interface ProductFinderInterface
{
    public function findAll(): array;

    public function findByIdentifier(string $uuid): ?Product;

    public function findByName(string $name): array;

    public function findByLastStatus(int $status): array;

    public function findByCreatedDate(string $createdDate): array;

    public function findByEvent(ProductEvent $productEvent): array;

}