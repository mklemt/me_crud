<?php


namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\AppDateTime;
use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\Product\Product;
use App\Domain\Model\ProductEvent;
use App\Domain\Model\ProductName;
use App\Domain\Model\Status;
use App\Infrastructure\Fixtures\IMemoryFixture;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class ProductTest extends TestCase
{
    public function testCanCreateProduct()
    {
        $uuid    = Uuid::v4()->toRfc4122();
        $name    = ProductName::create("Siłownik kategoria I");
        $product = Product::create($uuid, $name);
        $product->setLastStatus(Status::UPDATED);
        $this->assertCount(2, $product->getEvents());
    }

    public function testCanBuildProduct()
    {
        $uuid = Uuid::v4()->toRfc4122();
        $id   = Identifier::fromString($uuid);
        $name = ProductName::create("Siłownik kategoria I");

        $events[] = new ProductEvent(Status::create(Status::CREATED), AppDateTime::now());
        $events[] = new ProductEvent(Status::create(Status::UPDATED), AppDateTime::now());
        $events[] = new ProductEvent(Status::create(Status::WORKING), AppDateTime::now());
        $events[] = new ProductEvent(Status::create(Status::REMOVED), AppDateTime::now());

        $product = Product::build($uuid, $name, Status::UPDATED, AppDateTime::now(), $events);
        $this->assertCount(4, $product->getEvents());
    }

    public function testCanCreteProductFromFixtures()
    {
        $imemoryFixtures = new IMemoryFixture();
        $imemoryFixtures->createProducts(10);
        $this->assertCount(10, $imemoryFixtures->getProducts());
    }

}