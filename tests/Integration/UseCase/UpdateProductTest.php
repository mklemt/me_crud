<?php


namespace App\Tests\Integration\UseCase;

use App\Application\UseCase\UpdateProduct\UpdateProduct;

class UpdateProductTest extends BaseTest
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testUpdateProduct()
    {
        $updateCommand = new UpdateProduct($this->knownProduct->productId());
        $updateCommand->setName("Nowy telefon");
        $this->commandBus->dispatch($updateCommand);

        $product = $this->productService->getProduct($this->knownProduct->productId());
        self::assertSame("Nowy telefon", $product->name()->value());

    }

}