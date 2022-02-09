<?php

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Utils\Strings;
use App\Shared\Domain\ValueObject\StringValueObject;

abstract class Slug extends StringValueObject
{
    public function __construct(protected string $value)
    {
        $this->value = Strings::slugify($value);
    }
}
