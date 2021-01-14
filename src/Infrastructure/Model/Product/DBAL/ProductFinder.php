<?php


namespace App\Infrastructure\Model\Product\DBAL;

use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductFinderInterface;
use App\Domain\Model\ProductEvent\ProductEvent;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class ProductFinder implements ProductFinderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    private ObjectRepository $productRepository;
    private ObjectRepository $eventsRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager     = $entityManager;
        $this->productRepository = $this->entityManager->getRepository(Product::class);
        $this->eventsRepository  = $this->entityManager->getRepository(ProductEvent::class);
    }

    public function findAll(): array
    {
        $products = $this->productRepository->findAll();
        foreach ($products as $product) {
            $this->hydrateEvents($product);
        }

        return $products;
    }

    public function findByIdentifier(string $uuid): ?Product
    {
        $product = $this->productRepository->find($uuid);
        $this->hydrateEvents($product);

        return $product;
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

    /**
     * @param \Doctrine\Persistence\ObjectRepository $eventsRepository
     * @param Product $product
     */
    private function hydrateEvents(Product $product): void
    {
        $events = $this->eventsRepository->findBy(["productId" => $product->productId()]);
        $product->setEvents($events);
    }
}