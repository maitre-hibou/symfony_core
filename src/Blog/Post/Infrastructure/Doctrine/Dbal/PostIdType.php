<?php

namespace App\Blog\Post\Infrastructure\Doctrine\Dbal;

use App\Blog\Post\Domain\PostId;
use App\Shared\Infrastructure\Doctrine\Dbal\UuidType;

final class PostIdType extends UuidType
{
    public function typeClassName(): string
    {
        return PostId::class;
    }
}
