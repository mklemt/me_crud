<?php


namespace App\Domain\Model\Product;

use App\Domain\Exception\StatusDomainException;
use App\Domain\Model\AppDateTime;
use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\ProductEvent\ProductEvent;
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
    private array $events;
    private ProductName $productName;

    private function __construct(Identifier $productId, ProductName $name, AppDateTime $createdDate, Status $status)
    {
        $this->productId     = $productId;
        $this->currentStatus = $status;
        $this->createdDate   = $createdDate;
        $this->productName   = $name;
        $this->events        = [];
    }

    /**
     * @param string $uuid
     * @param ProductName $nazwa
     *
     * @return static
     * Create new Object
     */
    public static function create(string $uuid, ProductName $nazwa): self
    {
        $identifier = Identifier::fromString($uuid);
        $status     = Status::create(Status::CREATED);
        $product    = new self($identifier, $nazwa, AppDateTime::now(), $status);
        $product->addEvent(Status::CREATED);

        return $product;
    }

    /**
     * @param Identifier $uuid
     * @param ProductName $nazwa
     * @param Status $lastStatus
     * @param AppDateTime $createdDate
     *
     * @return static
     *
     * Hydronize Product
     */
    public static function build(Identifier $uuid, ProductName $nazwa, Status $lastStatus, AppDateTime $createdDate): self
    {
        return new self($uuid, $nazwa, $createdDate, $lastStatus);
    }

    public function remove()
    {
        $this->setStatus(Status::REMOVED);
    }

    public function setStatus(int $currentStatus)
    {
        $this->checkIfIsRemoved();
        if ($currentStatus == STATUS::CREATED) {
            StatusDomainException::productAlreadyHasCreatedStatus();
        }

        $this->currentStatus = Status::create($currentStatus);
        $this->addEvent($currentStatus);
    }

    public function id(): string
    {
        return $this->productId->asString();
    }

    public function events(): array
    {
        return $this->events;
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

    /**
     * @param ProductName $nazwa
     */
    public function setName(ProductName $nazwa): void
    {
        $this->checkIfIsRemoved();
        $this->productName = $nazwa;
    }

    public function addEvents($events)
    {
        $this->checkIfIsRemoved();
        $this->events = ProductEvent::buildEventsFromArray($events);
    }

    public function toArray()
    {
        $list = [
            'productId'     => $this->id(),
            'productName'   => $this->productName->value(),
            'currentStatus' => $this->currentStatus->statusAsString(),
            'createdDate'   => $this->createdTime()->toString(),
            'events'        => ProductEvent::convertEventsToArray($this->events()),
        ];

        return $list;
    }

    private function addEvent(int $status)
    {
        $date           = AppDateTime::now();
        $statusObject   = Status::create($status);
        $this->events[] = new ProductEvent($this->productId->asString(), $statusObject, $date);
    }

    private function checkIfIsRemoved(): void
    {
        if ($this->status()->equal(Status::create(STATUS::REMOVED))) {
            StatusDomainException::productAlreadyWasRemoved();
        }
    }
}