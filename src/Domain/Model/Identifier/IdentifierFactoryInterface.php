<?php


namespace App\Domain\Model\Identifier;

interface IdentifierFactoryInterface
{
    public function isValid(string $id):bool;

    public function generate():string;
}