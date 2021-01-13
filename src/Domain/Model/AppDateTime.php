<?php


namespace App\Domain\Model;

use App\Domain\Exception\AppDateTimeException;
use DateTimeImmutable;

final class AppDateTime
{
    const DATE_FORMAT = "Y-m-d h:i:ss";
    private DateTimeImmutable $dateTimeImmutable;

    private function __construct(DateTimeImmutable $dateTimeImmutable)
    {
        $this->dateTimeImmutable = $dateTimeImmutable;
    }

    public static function now(): self
    {
        $dateTimeImmutable = new DateTimeImmutable('now');

        return new self($dateTimeImmutable);
    }

    public static function createFromFormat(string $dateString, $format = self::DATE_FORMAT): self
    {
        if ( ! self::validateDate($dateString, $format)) {
            AppDateTimeException::notValidDateFormatString();
        }
        $dateTime = DateTimeImmutable::createFromFormat($format, $dateString);

        return new AppDateTime($dateTime);
    }

    public function value()
    {
        return $this->dateTimeImmutable;
    }

    public static function create(DateTimeImmutable $dateTime): self
    {
        if ( ! self::validateDate($dateTime)) {
            AppDateTimeException::notValidDateFormatString();
        }

        return new AppDateTime($dateTime);
    }

    public static function validateDate(string $dateString, $format = 'Y-m-d'): bool
    {
        $toValidate = DateTimeImmutable::createFromFormat($format, $dateString);

        return $toValidate && $toValidate->format($format) === $dateString;
    }

    public function toString(): string
    {
        return $this->dateTimeImmutable->format(self::DATE_FORMAT);
    }

}