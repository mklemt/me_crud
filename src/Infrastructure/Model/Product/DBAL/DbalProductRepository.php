<?php


namespace App\Infrastructure\Model\Product\DBAL;

use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\Identifier\IdentifierFactoryInterface;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

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
        $product = $this->entityManager->getRepository(Product::class)->find($uuid);

        return $product;
    }

    public function save(Product $product): string
    {
        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($product);
            foreach ($product->getEvents() as $productEvent) {
                $this->entityManager->persist($productEvent);
            }
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Exception $exception) {
            $this->entityManager->rollback();
        }


        return $product->productId();
    }

    public function nextIdentity(string $uuid = null): Identifier
    {
        if (empty($uuid)) {
            return Identifier::fromString($this->UUIDFactory->generate());
        }

        return Identifier::fromString($uuid);
    }

}