<?php


namespace App\Infrastructure\Model\Product\DBAL;

use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\Identifier\IdentifierFactoryInterface;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductPersistanceRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class DbalProductPersistanceRepository implements ProductPersistanceRepositoryInterface
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
            foreach ($product->events() as $productEvent) {
                $this->entityManager->persist($productEvent);
            }
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Exception $exception) {
            $this->entityManager->rollback();
        }


        return $product->id();
    }

    public function nextIdentity(string $uuid = null): Identifier
    {
        if (empty($uuid)) {
            return Identifier::fromString($this->UUIDFactory->generate());
        }

        return Identifier::fromString($uuid);
    }

    public function delete(string $uuid): string
    {
        try {
            $this->entityManager->beginTransaction();
            /** @var Product $product */
            $product = $this->entityManager->getRepository(Product::class)->find($uuid);
            $product->remove();
            $this->entityManager->persist($product);
            foreach ($product->events() as $productEvent) {
                $this->entityManager->persist($productEvent);
            }
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Exception $exception) {
            $this->entityManager->rollback();
        }


        return $product->id();
    }
}