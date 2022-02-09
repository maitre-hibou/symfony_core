<?php

namespace App\Shared\Domain;

use InvalidArgumentException;
use function Lambdish\Phunctional\instance_of;

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
        if (false === call_user_func(instance_of($className), $item)) {
            throw new InvalidArgumentException(sprintf('Object <%s> is not an instance of <%s>', get_class($item), $className));
        }
    }
}
