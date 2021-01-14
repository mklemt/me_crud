<?php


namespace App\Infrastructure\Model\Product\InMemory;

use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\Identifier\IdentifierFactoryInterface;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductPersistanceRepositoryInterface;
use App\Infrastructure\Fixtures\IMemoryFixture;

class RInMemoryProductPersistanceRepository implements ProductPersistanceRepositoryInterface
{
    private $productsRepository = [];
    /**
     * @var IdentifierFactoryInterface
     */
    private IdentifierFactoryInterface $UUIDFactory;

    public function __construct(IdentifierFactoryInterface $UUIDFactory)
    {
        $this->UUIDFactory        = $UUIDFactory;
        $this->productsRepository = $this->setRepository();
    }

    public function getById(string $uuid): ?Product
    {
        /** @var Product $product */
        foreach ($this->productsRepository as $product) {
            if ($product->id() == $uuid) {
                return $product;
            }
        }
        return null;
    }

    public function save(Product $product): string
    {
        $i = 0;
        /** @var Product $pr */
        foreach ($this->productsRepository as $pr) {
            if ($pr->id() == $product->id()) {
                $this->productsRepository[$i] = $product;

                return $pr->id();
            }
            $i++;
        }
        $this->productsRepository[] = $product;

        return $product->id();
    }

    public function nextIdentity(): Identifier
    {
        return Identifier::fromString($this->UUIDFactory->generate());
    }

    private function setRepository(): array
    {
        $imemoryFixtures = new IMemoryFixture();
        $imemoryFixtures->createProducts(10);

        return $imemoryFixtures->getProducts();
    }

}