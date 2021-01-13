<?php


namespace App\Application\CQRS;


interface QueryBusInterface
{
    public function handle(QueryInterface $query);
}