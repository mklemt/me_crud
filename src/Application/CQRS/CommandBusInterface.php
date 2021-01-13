<?php


namespace App\Application\CQRS;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}