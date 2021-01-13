<?php


namespace App\Infrastructure\Model\Identifier;

use App\Domain\Model\Identifier\IdentifierFactoryInterface;
use Symfony\Component\Uid\Uuid;

class UuidIdentifierBuilder implements IdentifierFactoryInterface
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