<?php


namespace App\Application\Service;

use App\Domain\Model\Product\Product;

class ApplicationService
{
    public static function hydrateEvents(Product $product, array $events): void
    {
        $product->addEvents($events);
    }
}