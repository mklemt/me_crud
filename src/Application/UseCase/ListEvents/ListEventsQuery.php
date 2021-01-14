<?php


namespace App\Application\UseCase\ListEvents;

use App\Application\CQRS\QueryInterface;

class ListEventsQuery implements QueryInterface
{
    private string $productId;

    public function __construct(string $productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }


}