<?php


namespace App\Infrastructure\Identifier;

use App\Domain\Model\Identifier\UUIDFactoryInterface;
use Symfony\Component\Uid\Uuid;

class IdentifierBuilder implements UUIDFactoryInterface
{
    /**
     * @param string $id
     *
     * @return bool
     */
    public function isValid(string $id): bool
    {
        return Uuid::isValid($id);
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        $id = Uuid::v4();

        return $id->toRfc4122();
    }

}