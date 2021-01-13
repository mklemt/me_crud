<?php


namespace App\Infrastructure\Model\Product\DBAL;

use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\Identifier\IdentifierFactoryInterface;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepositoryInterface;

class DbalProductRepository implements ProductRepositoryInterface
{
    /**
     * @var IdentifierFactoryInterface
     */
    private IdentifierFactoryInterface $UUIDFactory;

    public function __construct(IdentifierFactoryInterface $UUIDFactory)
    {
        $this->UUIDFactory = $UUIDFactory;
    }

    public function getById(string $uuid): ?Product
    {
        // TODO: Implement getById() method.
    }

    public function save(Product $product): string
    {
        // TODO: Implement save() method.
    }

    public function nextIdentity(): Identifier
    {
        return Identifier::fromString($this->UUIDFactory->generate());
    }

}