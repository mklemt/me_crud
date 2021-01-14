<?php


namespace App\Domain\Service;

use App\Domain\Model\ProductEvent\ProductEventFinderInterface;
use App\Domain\Model\ProductEvent\ProductEventRepositoryInterface;

class ProductEventService
{
    /**
     * @var ProductEventRepositoryInterface
     */
    private ProductEventRepositoryInterface $eventRepository;
    /**
     * @var ProductEventFinderInterface
     */
    private ProductEventFinderInterface $eventFinder;

    public function __construct(ProductEventRepositoryInterface $eventRepository, ProductEventFinderInterface $eventFinder)
    {
        $this->eventRepository = $eventRepository;
        $this->eventFinder = $eventFinder;
    }

}