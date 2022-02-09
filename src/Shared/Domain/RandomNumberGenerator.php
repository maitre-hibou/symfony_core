<?php

namespace App\Shared\Domain;

interface RandomNumberGenerator
{
    public function generate(int $min = 0, int $max = PHP_INT_MAX): int;
}
