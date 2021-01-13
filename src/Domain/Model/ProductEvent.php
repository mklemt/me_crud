<?php


namespace App\Domain\Model;

use App\Domain\Exception\ProductEventDomainException;
use App\Domain\Model\Identifier\Identifier;

class ProductEvent
{
    const DATE_FORMAT = "Ymdhis";
    private Status $status;
    private AppDateTime $eventTime;
    private Identifier $productId;
    private int $id;

    public function __construct(Identifier $productId, Status $status, AppDateTime $eventTime)
    {
        $this->status    = $status;
        $this->eventTime = $eventTime;
        $this->productId = $productId;
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
        return $this->status->equal($productEvent->status) && $this->productId->equal($productEvent->productId) && $this->eventTime->equal(
                $productEvent->eventTime
            );
    }

    public function toString()
    {
        return array(
            'id'          => $this->productId->asString(),
            'status'      => $this->status->statusAsString(),
            'status_date' => $this->eventTime->toString(),
        );

    }

}