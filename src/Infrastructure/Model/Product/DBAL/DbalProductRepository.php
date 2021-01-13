<?php


namespace App\Infrastructure\Model\Product\DBAL;

use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\Identifier\IdentifierFactoryInterface;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepositoryInterface;
use App\Domain\Model\ProductEvent;
use Doctrine\ORM\EntityManagerInterface;

class DbalProductRepository implements ProductRepositoryInterface
{
    /**
     * @var IdentifierFactoryInterface
     */
    private IdentifierFactoryInterface $UUIDFactory;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(IdentifierFactoryInterface $UUIDFactory, EntityManagerInterface $entityManager)
    {
        $this->UUIDFactory   = $UUIDFactory;
        $this->entityManager = $entityManager;
    }

    public function getById(string $uuid): ?Product
    {
        /** @var Product $product */
        $product       = $this->entityManager->getRepository(Product::class)->find($uuid);
        $productEvents = $this->entityManager->getRepository(ProductEvent::class)->findBy(['productId.uuid' => $uuid]);
        $product->setEvents($productEvents);

        return $product;
    }

    public function save(Product $product): string
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product->productId();
    }

    public function nextIdentity(): Identifier
    {
        return Identifier::fromString($this->UUIDFactory->generate());
    }

}