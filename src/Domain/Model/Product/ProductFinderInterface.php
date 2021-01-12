<?php


namespace App\Domain\Model\Product;


interface ProductFinderInterface
{
    public function findAllIdetificators(): array;

}