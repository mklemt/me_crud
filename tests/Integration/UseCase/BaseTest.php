<?php


namespace App\Tests\Integration\UseCase;

use App\Application\CQRS\CommandInterface;
use App\Application\UseCase\UpdateProduct\UpdateProduct;
use App\Domain\Model\Product\Product;
use App\Domain\Model\ProductName;
use App\Domain\Service\ProductService;
use App\Infrastructure\CQRS\MessengerCommandBus;
use App\Infrastructure\Model\Identifier\UuidIdentifierBuilder;
use App\Infrastructure\Model\Product\DBAL\DbalProductRepository;
use App\Infrastructure\Model\Product\InMemory\InMemoryProductRepository;
use App\Infrastructure\Model\Product\InMemory\RInMemoryProductRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

class BaseTest extends TestCase
{
    /**
     * @var ProductService
     */
    protected ProductService $productService;
    /**
     * @var Product
     */
    protected Product $knownProduct;
    /**
     * @var MessageBusInterface
     */
    protected MessageBusInterface $symfonyMessageBus;
    /**
     * @var MessengerCommandBus
     */
    protected MessengerCommandBus $commandBus;


    protected function setUp(): void
    {
        $identifierFactory  = new UuidIdentifierBuilder();
        $productRepository  = new InMemoryProductRepository($identifierFactory);
//        $productRepository  = new DbalProductRepository($identifierFactory);
        $uuid               = $uuid = Uuid::v4()->toRfc4122();
        $name               = ProductName::create("Telefon");
        $this->knownProduct = Product::create($uuid, $name);
        $productRepository->save($this->knownProduct);

        $this->productService    = new ProductService($productRepository);
        $this->symfonyMessageBus = $this->assembleSymfonyMessageBus();
        $this->commandBus        = new MessengerCommandBus($this->symfonyMessageBus);

    }
    public function testUpdateProduct()
    {
        $updateCommand = new UpdateProduct($this->knownProduct->productId());
        $updateCommand->setName("Nowy telefon");
        $this->commandBus->dispatch($updateCommand);
        self::assertSame($updateCommand, $this->symfonyMessageBus->lastDispatchedCommand());

    }

    private function assembleSymfonyMessageBus(): MessageBusInterface
    {
        return new class() implements MessageBusInterface {
            private CommandInterface $dispatchedCommand;

            public function dispatch($message, array $stamps = []): Envelope
            {
                $this->dispatchedCommand = $message;

                return new Envelope($message);
            }

            public function lastDispatchedCommand(): CommandInterface
            {
                return $this->dispatchedCommand;
            }
        };
    }

}