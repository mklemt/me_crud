<?php


namespace App\Domain\Model\Product;

use App\Domain\Exception\StatusDomainException;
use App\Domain\Model\AppDateTime;
use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\ProductEvent\ProductEvent;
use App\Domain\Model\ProductName;
use App\Domain\Model\Status;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
    private Collection $events;
    private ProductName $productName;

    private function __construct(Identifier $productId, ProductName $name, AppDateTime $createdDate, Status $status)
    {
        $this->productId     = $productId;
        $this->currentStatus = $status;
        $this->createdDate   = $createdDate;
        $this->productName   = $name;
        $this->events        = new ArrayCollection();
    }

    public static function create(string $uuid, ProductName $nazwa): self
    {
        $idObject     = Identifier::fromString($uuid);
        $statusObject = Status::create(Status::CREATED);
        $product      = new self($idObject, $nazwa, AppDateTime::now(), $statusObject);
        $product->addEvent(Status::CREATED);

        return $product;
    }

    public static function build(Identifier $uuid, ProductName $nazwa, Status $lastStatus, AppDateTime $createdDate): self
    {
        $product = new self($uuid, $nazwa, $createdDate, $lastStatus);

//        $product->events = ProductEvent::buildEventsFromArray($events);

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


    public function getEvents(): Collection
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
        $this->events[] = new ProductEvent($this->productId->asString(), $statusObject, $date);
    }

    public function setEvents(array $productEvents)
    {
//        $this->events = ProductEvent::buildEventsFromArray($productEvents);
    }

    public function toArray()
    {

        return [
            'productId'     => $this->productId(),
            'productName'   => $this->productName->value(),
            'currentStatus' => $this->currentStatus->statusAsString(),
            'createdDate'   => $this->createdTime()->toString(),
            'events'        => $this->getEvents(),
        ];

    }


}