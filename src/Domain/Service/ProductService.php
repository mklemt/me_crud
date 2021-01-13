<?php


namespace App\Domain\Service;

use App\Domain\Exception\ProductDomainException;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepositoryInterface;
use App\Domain\Model\ProductName;
use App\Domain\Model\Status;

class ProductService
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
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
            $product->setCurrentStatus($productStatus->status());
        }
        if ( ! empty($nazwa)) {
            $productName = ProductName::create($nazwa);
            $product->setProductName($productName);
        }

        return $product;
    }


    public function save(Product $product)
    {
        $this->productRepository->save($product);
    }

}