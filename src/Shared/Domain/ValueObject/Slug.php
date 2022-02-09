<?php

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Utils\Strings;

abstract class Slug extends StringValueObject
{
    public function __construct(protected string $value)
    {
        $this->value = Strings::slugify($value);
    }
}
