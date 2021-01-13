<?php


namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\AppDateTime;
use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\ProductEvent;
use App\Domain\Model\Status;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class ProductEventTest extends TestCase
{
    public function testEqualMetod()
    {
        $uuid = Uuid::v4()->toRfc4122();
        $id   = Identifier::fromString($uuid);
        $date = AppDateTime::now();

        $event1 = new ProductEvent($id, Status::create(Status::CREATED), $date);
        $event2 = new ProductEvent($id, Status::create(Status::CREATED), $date);
        $this->assertTrue($event1->equal($event2));
    }

}