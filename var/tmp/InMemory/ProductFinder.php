<?php


namespace App\Infrastructure\Model\Product\InMemory;

use App\Domain\Model\AppDateTime;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductFinderInterface;
use App\Domain\Model\ProductEvent;
use App\Domain\Model\ProductName;
use App\Domain\Model\Status;
use App\Infrastructure\Fixtures\IMemoryFixture;

class ProductFinder implements ProductFinderInterface
{
    private array $productsRepository;

    public function __construct()
    {
        $this->productsRepository = $this->setRepository();
    }

    public function findAll(): array
    {
        return $this->productsRepository;
    }

    public function findByIdentifier(string $uuid): ?Product
    {
        /** @var Product $product */
        foreach ($this->productsRepository as $product) {
            if ($product->productId() == $uuid) {
                return $product;
            }
        }
    }

    public function findByName(string $name): array
    {
        $products = [];
        $findName = ProductName::create($name);
        /** @var Product $product */
        foreach ($this->productsRepository as $product) {
            if ($product->name()->equal($findName)) {
                $products[] = $product;
            }
        }

        return $products;
    }

    public function findByLastStatus(int $status): array
    {
        $products   = [];
        $findStatus = Status::create($status);
        /** @var Product $product */
        foreach ($this->productsRepository as $product) {
            if ($product->status()->equal($findStatus)) {
                $products[] = $product;
            }
        }

        return $products;
    }

    public function findByCreatedDate(string $createdDate): array
    {
        $products       = [];
        $createdAppDate = AppDateTime::createFromFormat($createdDate);
        /** @var Product $product */
        foreach ($this->productsRepository as $product) {
            if ($product->createdTime()->toString() == $createdAppDate->toString()) {
                $products[] = $product;
            }
        }

        return $products;
    }

    public function findByEvent(ProductEvent $productEvent): array
    {
        // TODO: Implement findByEvent() method.
    }

    private function setRepository(): array
    {
        $imemoryFixtures = new IMemoryFixture();
        $imemoryFixtures->createProducts(10);

        return $imemoryFixtures->getProducts();
    }
}