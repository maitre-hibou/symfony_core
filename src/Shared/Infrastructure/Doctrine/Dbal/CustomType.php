<?php

namespace App\Shared\Infrastructure\Doctrine\Dbal;

interface CustomType
{
    public static function customTypeName(): string;
}
