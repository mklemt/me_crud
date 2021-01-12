<?php


namespace App\Domain\Model\Identifier;


interface UUIDFactoryInterface
{
    public function isValid(string $id):bool;

    public function generate():string;
}