<?php


namespace App\Domain\Model;

use App\Domain\Exception\AppDateTimeException;
use DateTime;

final class AppDateTime
{
    const DATE_FORMAT = "Y-m-d H:i:s";
    private DateTime $dateTime;

    private function __construct(DateTime $dateTimeImmutable)
    {
        $this->dateTime = $dateTimeImmutable;
    }

    public static function now(): self
    {
        $dateTimeImmutable = new DateTime('now');

        return new self($dateTimeImmutable);
    }

    public static function createFromFormat(string $dateString, $format = self::DATE_FORMAT): self
    {
        if ( ! self::validateDate($dateString, $format)) {
            AppDateTimeException::notValidDateFormatString();
        }
        $dateTime = DateTime::createFromFormat($format, $dateString);

        return new AppDateTime($dateTime);
    }

    public function equal(AppDateTime $dateTime)
    {
        return $this->dateTime === $dateTime->dateTime;
    }

    public function value()
    {
        return $this->dateTime;
    }

    public static function create(DateTime $dateTime): self
    {
        if ( ! self::validateDate($dateTime)) {
            AppDateTimeException::notValidDateFormatString();
        }

        return new AppDateTime($dateTime);
    }

    public static function validateDate(string $dateString, $format = 'Y-m-d'): bool
    {
        $toValidate = DateTime::createFromFormat($format, $dateString);

        return $toValidate && $toValidate->format($format) === $dateString;
    }

    public function toString(): string
    {
        return $this->dateTime->format(self::DATE_FORMAT);
    }

}