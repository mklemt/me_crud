<?php


namespace App\Infrastructure\Fixtures;


use App\Domain\Model\AppDateTime;
use App\Domain\Model\Product\Product;
use App\Domain\Model\ProductEvent;
use App\Domain\Model\ProductName;
use App\Domain\Model\Status;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class IMemoryFixture
{
    private array $products;

    public function createProducts(int $licznik)
    {
        for ($i = 1; $i <= $licznik; $i++) {
            $this->products[] = $this->createOneProduct($i);
        }
    }


    private function createOneProduct(int $licznik)
    {
        $statuses  = [Status::UPDATED, Status::REMOVED, Status::WORKING];
        $uuid    = Uuid::v4()->toRfc4122();
        $name    = ProductName::create(sprintf("Siłownik cat. %s nr %s", $licznik, substr(str_replace('-', '', $uuid), 1, 6)));
        $product = Product::create($uuid, $name);
        for ($i = 0; $i < 4; $i++) {
            $rand_key = array_rand($statuses, 1);
            $product->setCurrentStatus($statuses[$rand_key]);
        }

        return $product;

    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }


}