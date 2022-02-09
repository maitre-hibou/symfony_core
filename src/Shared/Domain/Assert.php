<?php

namespace App\Shared\Domain;

use InvalidArgumentException;

final class Assert
{
    public static function arrayOf(string $className, array $items): void
    {
        foreach ($items as $item) {
            self::instanceOf($className, $item);
        }
    }

    public static function instanceOf(string $className, mixed $item): void
    {
        if (false === ($item instanceof $className)) {
            throw new InvalidArgumentException(sprintf('Object <%s> is not an instance of <%s>', get_class($item), $className));
        }
    }
}
