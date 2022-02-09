<?php

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Shared\Domain\Utils\Strings;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Doctrine\Dbal\CustomType;
use function Lambdish\Phunctional\last;

abstract class UuidType extends StringType implements CustomType
{
    abstract protected function typeClassName(): string;

    public static function customTypeName(): string
    {
        /**
         * @psalm-suppress PossiblyNullArgument
         */
        return Strings::toSnakeCase(str_replace('Type', '', last(explode('\\', static::class))));
    }

    public function getName(): string
    {
        return self::customTypeName();
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var Uuid $value */
        return $value->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->typeClassName();

        return new $className($value);
    }
}
