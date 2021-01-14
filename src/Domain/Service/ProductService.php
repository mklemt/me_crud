<?php


namespace App\Domain\Service;

use App\Domain\Exception\ProductDomainException;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductQueryRepositoryInterface;
use App\Domain\Model\Product\ProductPersistanceRepositoryInterface;
use App\Domain\Model\ProductName;
use App\Domain\Model\Status;

class ProductService
{
    private ProductPersistanceRepositoryInterface $productRepository;
    /**
     * @var ProductQueryRepositoryInterface
     */
    private ProductQueryRepositoryInterface $productFinder;

    public function __construct(ProductPersistanceRepositoryInterface $productRepository, ProductQueryRepositoryInterface $productFinder)
    {
        $this->productRepository = $productRepository;
        $this->productFinder     = $productFinder;
    }

    public function createProduct(string $nazwa): Product
    {
        $productName = ProductName::create($nazwa);

        return Product::create($this->productRepository->nextIdentity(), $productName);
    }

    public function getProduct(string $uuid): ?Product
    {
        $product = $this->productRepository->getById($uuid);
        if (empty($product)) {
            ProductDomainException::productNotExist();
        }

        return $product;
    }

    public function buildProduct(string $uuid, ?int $status, ?string $nazwa): ?Product
    {
        $product = $this->productRepository->getById($uuid);
        if (empty($product)) {
            ProductDomainException::productNotExist();
        }
        if ( ! empty($status)) {
            $productStatus = Status::create($status);
            $product->setStatus($productStatus->status());
        }
        if ( ! empty($nazwa)) {
            $productName = ProductName::create($nazwa);
            $product->setName($productName);
        }

        return $product;
    }


    public function save(Product $product)
    {
        $this->productRepository->save($product);
    }

    public function newIdentity(string $uuid = null)
    {
        return $this->productRepository->nextIdentity($uuid);
    }

    public function newUuidString()
    {
        return $this->productRepository->nextIdentity()->asString();
    }

}