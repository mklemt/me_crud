<?php


namespace App\Tests\Integration\UseCase;

use App\Application\CQRS\CommandInterface;
use App\Application\UseCase\UpdateProduct\UpdateProduct;
use App\Domain\Model\Product\Product;
use App\Domain\Model\ProductName;
use App\Domain\Service\ProductService;
use App\Infrastructure\CQRS\MessengerCommandBus;
use App\Infrastructure\Model\Identifier\UuidIdentifierBuilder;
use App\Infrastructure\Model\Product\DBAL\DbalProductPersistanceRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

class BaseTest extends KernelTestCase
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
    protected $entityManager;
    protected $knownProductId;


    protected function setUp(): void
    {

        $kernel               = self::bootKernel();
        $this->knownProductId = 'bfd3293b-19b2-4f17-8b64-40191e27ce65';

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        $identifierFactory       = new UuidIdentifierBuilder();
        $productRepository       = new DbalProductPersistanceRepository($identifierFactory, $this->entityManager);
        $this->symfonyMessageBus = $this->assembleSymfonyMessageBus();
        $this->commandBus        = new MessengerCommandBus($this->symfonyMessageBus);

        $this->productService = new ProductService($productRepository);

    }

    public function testUpdateProduct()
    {
        $updateCommand = new UpdateProduct($this->knownProductId);
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