<?php

namespace App\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid extends StringValueObject
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValidUuid($value);
    }

    public function equals(Uuid $other): bool
    {
        return $this->value() === $other->value();
    }

    public static function random(): Uuid
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    private function ensureIsValidUuid(string $id): void
    {
        if (!RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>', static::class, $id));
        }
    }
}
