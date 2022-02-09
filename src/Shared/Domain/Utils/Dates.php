<?php

namespace App\Shared\Domain\Utils;

use DateTimeInterface;

final class Dates
{
    public static function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }
}
