<?php


namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\AppDateTime;
use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\Product\Product;
use App\Domain\Model\ProductName;
use App\Domain\Model\Status;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class ProductTest extends TestCase
{
    public function testCanCreateProduct()
    {
        $uuid    = Uuid::v4()->toRfc4122();
        $name    = ProductName::create("Siłownik kategoria I");
        $product = Product::create($uuid, $name);
        $product->setStatus(Status::UPDATED);
        $this->assertCount(2, $product->events());
    }

    public function testCanBuildProduct()
    {
        $uuid = Uuid::v4()->toRfc4122();
        $id   = Identifier::fromString($uuid);
        $name = ProductName::create("Siłownik kategoria I");

        $product = Product::build($id, $name, Status::create(Status::UPDATED), AppDateTime::now());
        $product->setStatus(Status::UPDATED);
        $product->setStatus(Status::WORKING);
        $product->setStatus(Status::REMOVED);
        $this->assertCount(3, $product->events());
    }

    public function testIfICanAddEventsToProduct()
    {
        $uuid = 'bfd3293b-19b2-4f17-8b64-40191e27ce65';
        $id   = Identifier::fromString($uuid);
        $name = ProductName::create("Siłownik kategoria I");

        $product = Product::build($id, $name, Status::create(Status::UPDATED), AppDateTime::now());
        $product->setStatus(Status::UPDATED);
        $product->setStatus(Status::WORKING);
        $product->setStatus(Status::REMOVED);

        $product = Product::build($id, $name, Status::create(Status::UPDATED), AppDateTime::now());
        $this->assertNotEmpty($product);
    }

}