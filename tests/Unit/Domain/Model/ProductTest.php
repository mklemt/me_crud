<?php


namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\AppDateTime;
use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\Product\Product;
use App\Domain\Model\ProductEvent\ProductEvent;
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
        $product->setCurrentStatus(Status::UPDATED);
        $this->assertCount(2, $product->getEvents());
    }

//    public function testCanBuildProduct()
//    {
//        $uuid = Uuid::v4()->toRfc4122();
//        $id   = Identifier::fromString($uuid);
//        $name = ProductName::create("Siłownik kategoria I");
//
//        $events[] = new ProductEvent($id, Status::create(Status::CREATED), AppDateTime::now());
//        $events[] = new ProductEvent($id, Status::create(Status::UPDATED), AppDateTime::now());
//        $events[] = new ProductEvent($id, Status::create(Status::WORKING), AppDateTime::now());
//        $events[] = new ProductEvent($id, Status::create(Status::REMOVED), AppDateTime::now());
//
//        $product = Product::build($id, $name, Status::create(Status::UPDATED), AppDateTime::now());
//        $this->assertCount(4, $product->getEvents());
//    }

//    public function testIfICanAddEventsToProduct()
//    {
//        $uuid = 'bfd3293b-19b2-4f17-8b64-40191e27ce65';
//        $id   = Identifier::fromString($uuid);
//        $name = ProductName::create("Siłownik kategoria I");
//
//        $product = Product::build($id, $name, Status::create(Status::UPDATED), AppDateTime::now());
//        $product->setCurrentStatus(Status::UPDATED);
//        $product->setCurrentStatus(Status::WORKING);
//        $product->setCurrentStatus(Status::REMOVED);
//
////        $events[] = new ProductEvent($id, Status::create(Status::CREATED), AppDateTime::now());
////        $events[] = new ProductEvent($id, Status::create(Status::UPDATED), AppDateTime::now());
////        $events[] = new ProductEvent($id, Status::create(Status::WORKING), AppDateTime::now());
////        $events[] = new ProductEvent($id, Status::create(Status::REMOVED), AppDateTime::now());
//
////        $product = Product::build($id, $name, Status::create(Status::UPDATED), AppDateTime::now());
//        $this->assertCount(3, $product->getEvents());
//    }

    public function testCanCreteProductFromFixtures()
    {
        $imemoryFixtures = new IMemoryFixture();
        $imemoryFixtures->createProducts(10);
        $this->assertCount(10, $imemoryFixtures->getProducts());
    }

}