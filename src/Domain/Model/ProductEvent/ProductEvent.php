<?php


namespace App\Domain\Model\ProductEvent;

use App\Domain\Exception\ProductEventDomainException;
use App\Domain\Model\AppDateTime;
use App\Domain\Model\Identifier\Identifier;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Status;

class ProductEvent
{
    const DATE_FORMAT = "Ymdhis";
    private Status $productStatus;
    private AppDateTime $eventTime;
    private string $productId;
    private Product $product;
    private int $eventId;

    public function __construct(string $productId, Status $status, AppDateTime $eventTime)
    {
        $this->productStatus = $status;
        $this->eventTime     = $eventTime;
        $this->productId     = $productId;
    }

    public static function buildEventsFromArray(array $events): array
    {
        $productEvents = array();
        foreach ($events as $event) {
            if ( ! $event instanceof ProductEvent) {
                ProductEventDomainException::objectIsNotValidType();
            }
            $productEvents[] = $event;
        }

        return $productEvents;
    }

    public function equal(ProductEvent $productEvent)
    {
        return $this->productStatus->equal(
                $productEvent->productStatus
            ) && $this->productId == $productEvent->productId && $this->eventTime->equal(
                $productEvent->eventTime
            );
    }

    public function toString()
    {
        return array(
            'id'          => $this->productId,
            'status'      => $this->productStatus->statusAsString(),
            'status_date' => $this->eventTime->toString(),
        );

    }

}