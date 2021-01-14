<?php


namespace App\UI\Controller;

use App\Application\UseCase\CreateProduct\CreateProduct;
use App\Application\UseCase\ListAllProducts\ListAllProductsQuery;
use App\Application\UseCase\UpdateProduct\UpdateProduct;
use App\Infrastructure\CQRS\MessengerCommandBus;
use App\Infrastructure\CQRS\MessengerQueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

/**
 * Class APIController
 * @package App\UI\Controller
 *
 * @Route("/api/products", name="api_products_")
 */
class APIController extends AbstractController
{
    /**
     * @var MessengerCommandBus
     */
    private MessengerCommandBus $commandBus;
    /**
     * @var MessengerQueryBus
     */
    private MessengerQueryBus $queryBus;

    public function __construct(MessengerCommandBus $commandBus, MessengerQueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
    }

    /**
     * @Route("/{id}", methods={"PUT"}, name="edit")
     */
    public function edit(string $id): Response
    {
        $updateCommand = new UpdateProduct($id);
        $updateCommand->setName("Nowy telefon");
        $this->commandBus->dispatch($updateCommand);

        return $this->json(['id' => $id]);
    }

    /**
     * @Route("/", methods={"GET"}, name="index")
     */
    public function index(): Response
    {
        $query   = new ListAllProductsQuery();
        $products = $this->queryBus->handle($query);

        return $this->json(['products' => $products]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="filter")
     */
    public function filter(string $id): Response
    {
        return $this->json(['id' => $id]);
    }

    /**
     * @Route("/{id}/events", methods={"GET"}, name="events")
     */
    public function events(string $id): Response
    {
        return $this->json(['id' => $id]);
    }

    /**
     * @Route("/", methods={"POST"}, name="add")
     */
    public function add(): Response
    {
        $uuid          = Uuid::v4()->toRfc4122();
        $createProduct = new CreateProduct($uuid, "Telefon stacjonarny");
        $this->commandBus->dispatch($createProduct);

        return $this->json(['id' => $uuid]);
    }
}