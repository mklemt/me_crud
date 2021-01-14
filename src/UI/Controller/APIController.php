<?php


namespace App\UI\Controller;

use App\Application\UseCase\CreateProduct\CreateProduct;
use App\Application\UseCase\FilterProduct\FilterProductQuery;
use App\Application\UseCase\ListAllProducts\ListAllProductsQuery;
use App\Application\UseCase\ListEvents\ListEventsQuery;
use App\Application\UseCase\UpdateProduct\UpdateProduct;
use App\Infrastructure\CQRS\MessengerCommandBus;
use App\Infrastructure\CQRS\MessengerQueryBus;
use App\Infrastructure\Service\ResponseStatus;
use Exception;
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
    /**
     * @var ResponseStatus
     */
    private ResponseStatus $status;

    public function __construct(MessengerCommandBus $commandBus, MessengerQueryBus $queryBus, ResponseStatus $status)
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
        $this->status     = $status;
    }

    /**
     * @Route("/{id}", methods={"PUT"}, name="edit")
     */
    public function edit(string $id, Request $request): Response
    {
        $status = $this->status->nothingToDo();
        $data   = json_decode($request->getContent(), true);
        if (is_array($data) && array_key_exists('name', $data)) {
            try {
                $updateCommand = new UpdateProduct($id);
                $updateCommand->setName($data['name']);
                $this->commandBus->dispatch($updateCommand);
                $status = $this->status->ok();
            } catch (Exception $exception) {
                $status = $this->status->error($exception);
            }
        }

        return $this->json(['id' => $id, 'status' => $status]);

    }

    /**
     * @Route("/", methods={"GET"}, name="index")
     */
    public function index(): Response
    {
        $status   = $this->status->nothingToDo();
        $products = [];
        try {
            $query    = new ListAllProductsQuery();
            $products = $this->queryBus->handle($query);
            $status   = $this->status->ok();
        } catch (Exception $exception) {
            $status = $this->status->error($exception);
        }

        return $this->json(['products' => $products, 'status' => $status]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="filter")
     */
    public function filter(string $id, Request $request): Response
    {
        $status   = $this->status->nothingToDo();
        $products = [];
        $data     = json_decode($request->getContent(), true);
        if (is_array($data)) {
            try {
                $query    = new FilterProductQuery($data);
                $products = $this->queryBus->handle($query);
                $status   = $this->status->ok();
            } catch (Exception $exception) {
                $status = $this->status->error($exception);
            }
        }

        return $this->json(['products' => $products, 'status' => $status]);
    }

    /**
     * @Route("/{id}/events", methods={"GET"}, name="events")
     */
    public function events(string $id): Response
    {
        $status = $this->status->nothingToDo();
        try {
            $query   = new ListEventsQuery($id);
            $product = $this->queryBus->handle($query);
            $status  = $this->status->ok();
        } catch (Exception $exception) {
            $status = $this->status->error($exception);
        }

        return $this->json(['products' => $product, 'status' => $status]);
    }

    /**
     * @Route("/", methods={"POST"}, name="add")
     */
    public function add(Request $request): Response
    {
        $status = $this->status->nothingToDo();
        try {
            $data          = json_decode($request->getContent(), true);
            $uuid          = Uuid::v4()->toRfc4122();
            $createProduct = new CreateProduct($uuid, $data['name']);
            $this->commandBus->dispatch($createProduct);
            $status = $this->status->ok();
        } catch (Exception $exception) {
            $status = $this->status->error($exception);
        }

        return $this->json(['id' => $uuid, 'status' => $status]);
    }
}