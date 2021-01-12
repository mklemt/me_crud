<?php


namespace App\Domain\Model;

use App\Domain\Exception\ProductNameDomainException;

final class ProductName
{
    const MIN_LENGTH = 2;
    const MAX_LENGTH = 50;
    private string $productName;

    /**
     * ProductName constructor.
     *
     * @param string $productName
     */
    private function __construct(string $productName)
    {
        $this->productName = $productName;
    }

    /**
     * @param string $productName
     *
     * @throws ProductNameDomainException
     */
    private static function assertLengthString(string $productName): void
    {
        if (empty($productName)) {
            ProductNameDomainException::isEmpty();
        }
        if (strlen($productName) < self::MIN_LENGTH) {
            ProductNameDomainException::isTooShort($productName, self::MIN_LENGTH);
        }
        if (strlen($productName) > self::MAX_LENGTH) {
            ProductNameDomainException::isTooLong($productName, self::MAX_LENGTH);
        }
    }

    /**
     * @param string $productName
     *
     * @return static
     * @throws ProductNameDomainException
     */
    public static function create(string $productName): self
    {
        self::assertLengthString($productName);

        return new self($productName);
    }

    /**
     * @param ProductName $name
     *
     * @return bool
     */
    public function equal(ProductName $name): bool
    {
        return $this->productName === $name->productName;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->productName;

    }

}