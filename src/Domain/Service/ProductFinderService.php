<?php


namespace App\Domain\Service;


use App\Domain\Model\Product\ProductFinderInterface;

class ProductFinderService
{
    /**
     * @var ProductFinderInterface
     */
    private ProductFinderInterface $productFinder;

    public function __construct(ProductFinderInterface $productFinder)
    {
        $this->productFinder = $productFinder;
    }

    public function findAll()
    {
//        $products
    }

}