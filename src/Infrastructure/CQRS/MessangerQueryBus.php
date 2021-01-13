<?php


namespace App\Infrastructure\CQRS;

use App\Application\CQRS\QueryBusInterface;
use App\Application\CQRS\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessangerQueryBus implements QueryBusInterface
{
    use HandleTrait {
        handle as handleQuery;
    }
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }
    public function handle(QueryInterface $query)
    {
        return $this->handleQuery($query);
    }
}