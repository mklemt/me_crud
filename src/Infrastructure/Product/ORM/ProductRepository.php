<?php


namespace App\Infrastructure\Product\ORM;

use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\Identifier\UUIDFactoryInterface;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var UUIDFactoryInterface
     */
    private UUIDFactoryInterface $UUIDFactory;

    public function __construct(UUIDFactoryInterface $UUIDFactory)
    {
        $this->UUIDFactory = $UUIDFactory;
    }

    public function getById(string $uuid): ?Product
    {
        // TODO: Implement getById() method.
    }

    public function save(Product $product)
    {
        // TODO: Implement save() method.
    }

    public function nextIdentity(): Identifier
    {
        return Identifier::fromString($this->UUIDFactory->generate());
    }

}