<?php


namespace App\Domain\Model\Product;

use App\Domain\Exception\StatusDomainException;
use App\Domain\Model\AppDateTime;
use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\ProductEvent;
use App\Domain\Model\ProductName;
use App\Domain\Model\Status;

class Product
{
    /**
     * @var Identifier
     */
    private Identifier $productId;
    /**
     * @var ?Status
     */
    private Status $currentStatus;
    private AppDateTime $createdDate;
    private array $events = [];
    private ProductName $productName;

    private function __construct(Identifier $productId, ProductName $name, AppDateTime $createdDate, Status $status)
    {
        $this->productId     = $productId;
        $this->currentStatus = $status;
        $this->createdDate   = $createdDate;
        $this->productName   = $name;
    }

    public static function create(string $uuid, ProductName $nazwa): self
    {
        $idObject     = Identifier::fromString($uuid);
        $statusObject = Status::create(Status::CREATED);
        $product      = new self($idObject, $nazwa, AppDateTime::now(), $statusObject);
        $product->addEvent(Status::CREATED);

        return $product;
    }

    public static function build(Identifier $uuid, ProductName $nazwa, Status $lastStatus, AppDateTime $createdDate, array $events): self
    {
        $product         = new self($uuid, $nazwa, $createdDate, $lastStatus);
        $product->events = ProductEvent::buildEventsFromArray($events);

        return $product;
    }


    public function setCurrentStatus(int $currentStatus)
    {
        if ($currentStatus == STATUS::CREATED) {
            StatusDomainException::productAlreadyHasCreatedStatus();
        }
        $this->addEvent($currentStatus);
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
    public function setProductName(ProductName $nazwa): void
    {
        $this->productName = $nazwa;
    }

    public function name()
    {
        return $this->productName;
    }

    public function status()
    {
        return $this->currentStatus;
    }

    public function createdTime()
    {
        return $this->createdDate;
    }


    private function addEvent(int $status)
    {
        $date           = AppDateTime::now();
        $statusObject   = Status::create($status);
        $this->events[] = new ProductEvent($this->productId, $statusObject, $date);
    }

    public function setEvents(array $productEvents)
    {
        $this->events = ProductEvent::buildEventsFromArray($productEvents);
    }


}