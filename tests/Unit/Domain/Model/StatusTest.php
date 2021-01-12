<?php


namespace App\Tests\Unit\Domain\Model;


use App\Domain\Exception\StatusDomainException;
use App\Domain\Model\Status;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testIfCanCreateStatus()
    {
        $statusNr     = 10;
        $status       = Status::create($statusNr);
        $allStatustes = $status->getAllStatuses();
        $this->assertSame($allStatustes[$statusNr], $status->statusAsString());

    }

    public function testIfCanCreateWrongStatus()
    {
        $this->expectException(StatusDomainException::class);
        $statusNr = 60;
        $status   = Status::create($statusNr);
    }
}