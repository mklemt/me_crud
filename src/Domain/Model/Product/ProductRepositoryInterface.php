<?php


namespace App\Domain\Model\Product;

use App\Domain\Model\Identifier\Identifier;

interface ProductRepositoryInterface
{
    public function getById(string $uuid): ?Product;

    public function save(Product $product): string;

    public function delete(string $uuid): string;

    public function nextIdentity(string $uuid = null): Identifier;
}