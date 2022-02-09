<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\RandomNumberGenerator as RandomNumberGeneratorInterface;

final class RandomNumberGenerator implements RandomNumberGeneratorInterface
{
    public function generate(int $min = 0, int $max = PHP_INT_MAX): int
    {
        return random_int($min, $max);
    }
}
