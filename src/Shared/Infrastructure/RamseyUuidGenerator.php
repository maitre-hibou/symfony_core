<?php

namespace App\Shared\Infrastructure;

use Ramsey\Uuid\Uuid;
use App\Shared\Domain\UuidGenerator;

final class RamseyUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
