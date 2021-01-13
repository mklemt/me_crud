<?php


namespace App\UI\Controller;

use App\Application\UseCase\UpdateProduct\UpdateProduct;
use App\Infrastructure\CQRS\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
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
        return $this->json(['id' => 'all']);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="filter")
     */
    public function filter(string $id): Response
    {
        return $this->json(['id' => $id]);
    }

    /**
     * @Route("/", methods={"POST"}, name="add")
     */
    public function add(): Response
    {
        return $this->json(['id' => 'new']);
    }
}