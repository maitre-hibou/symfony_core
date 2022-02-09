<?php

namespace App\Shared\Domain\ValueObject;

use ReflectionClass;
use Stringable;
use App\Shared\Domain\Utils\Strings;

use function Lambdish\Phunctional\reindex;

abstract class Enum implements Stringable
{
    protected static array $cache = [];

    public function __construct(protected mixed $value)
    {
        $this->ensureIsBetweenAcceptedValues($value);
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public static function __callStatic(string $name, array $arguments)
    {
        /**
         * @psalm-suppress UnsafeInstantiation
         */
        return new static(self::values()[$name]);
    }

    public static function fromString(string $value): Enum
    {
        /**
         * @psalm-suppress UnsafeInstantiation
         */
        return new static($value);
    }

    public static function values(): array
    {
        $class = static::class;

        if (false === array_key_exists($class, self::$cache)) {
            $reflected = new ReflectionClass($class);
            self::$cache[$class] = reindex(self::keysFormatter(), $reflected->getConstants());
        }

        return self::$cache[$class];
    }

    abstract protected function throwExceptionForInvalidValue(mixed $value): void;

    private static function keysFormatter(): callable
    {
        return static fn(mixed $unused, string $key): string => Strings::toCamelCase(strtolower($key));
    }

    private function ensureIsBetweenAcceptedValues(mixed $value): void
    {
        if (!in_array($value, static::values(), true)) {
            $this->throwExceptionForInvalidValue($value);
        }
    }
}
