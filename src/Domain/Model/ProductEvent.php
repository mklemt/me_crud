<?php


namespace App\Domain\Model;

use App\Domain\Exception\ProductEventDomainException;
use App\Domain\Model\Identifier\Identifier;

final class ProductEvent
{
    const DATE_FORMAT = "Ymdhis";
    private Status $status;
    private AppDateTime $eventTime;
    private Identifier $productId;

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

    public function toString()
    {
        return array(
            'status'      => $this->status->statusAsString(),
            'status_date' => $this->eventTime->toString(),
        );

    }

}