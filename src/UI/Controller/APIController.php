<?php


namespace App\UI\Controller;

use App\Application\UseCase\CreateProduct\CreateProduct;
use App\Application\UseCase\ListAllProducts\ListAllProductsQuery;
use App\Application\UseCase\ListEvents\ListEventsQuery;
use App\Application\UseCase\UpdateProduct\UpdateProduct;
use App\Infrastructure\CQRS\MessengerCommandBus;
use App\Infrastructure\CQRS\MessengerQueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function edit(string $id, Request $request): Response
    {
        $data          = json_decode($request->getContent(), true);
        $updateCommand = new UpdateProduct($id);
        $updateCommand->setName($data['name']);
        $this->commandBus->dispatch($updateCommand);

        return $this->json(['id' => $id]);
    }

    /**
     * @Route("/", methods={"GET"}, name="index")
     */
    public function index(): Response
    {
        $query    = new ListAllProductsQuery();
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
        $query   = new ListEventsQuery($id);
        $product = $this->queryBus->handle($query);

        return $this->json(['products' => $product]);
    }

    /**
     * @Route("/", methods={"POST"}, name="add")
     */
    public function add(Request $request): Response
    {
        $data          = json_decode($request->getContent(), true);
        $uuid          = Uuid::v4()->toRfc4122();
        $createProduct = new CreateProduct($uuid, $data['name']);
        $this->commandBus->dispatch($createProduct);

        return $this->json(['id' => $uuid]);
    }
}