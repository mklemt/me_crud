<?php


namespace App\Domain\Model\Product;

use App\Domain\Exception\StatusDomainException;
use App\Domain\Model\AppDateTime;
use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\ProductEvent;
use App\Domain\Model\ProductName;
use App\Domain\Model\Status;

final class Product
{
    /**
     * @var Identifier
     */
    private Identifier $productId;
    /**
     * @var ?Status
     */
    private Status $lastStatus;
    private AppDateTime $createdDate;
    private array $events = [];
    private ProductName $nazwa;

    private function __construct(Identifier $productId, ProductName $nazwa, AppDateTime $createdDate, Status $status)
    {
        $this->productId   = $productId;
        $this->lastStatus  = $status;
        $this->createdDate = $createdDate;
        $this->nazwa       = $nazwa;
    }

    public static function create(string $uuid, ProductName $nazwa): self
    {
        $idObject     = Identifier::fromString($uuid);
        $statusObject = Status::create(Status::CREATED);
        $product      = new self($idObject, $nazwa, AppDateTime::now(), $statusObject);
        $product->addEvent(Status::CREATED);

        return $product;
    }

    public static function build(string $uuid, ProductName $nazwa, int $lastStatus, AppDateTime $createdDate, array $events): self
    {
        $idObject        = Identifier::fromString($uuid);
        $statusObject    = Status::create($lastStatus);
        $product         = new self($idObject, $nazwa, $createdDate, $statusObject);
        $product->events = ProductEvent::buildEventsFromArray($events);

        return $product;
    }

    public function setLastStatus(int $lastStatus)
    {
        if ($lastStatus == STATUS::CREATED) {
            StatusDomainException::productAlreadyHasCreatedStatus();
        }
        $this->addEvent($lastStatus);
    }

    public function productId(): string
    {
        return $this->productId->asString();

    }

    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @param ProductName $nazwa
     */
    public function setNazwa(ProductName $nazwa): void
    {
        $this->nazwa = $nazwa;
    }


    private function addEvent(int $status)
    {
        $date           = AppDateTime::now();
        $statusObject   = Status::create($status);
        $this->events[] = new ProductEvent($statusObject, $date);
    }



}