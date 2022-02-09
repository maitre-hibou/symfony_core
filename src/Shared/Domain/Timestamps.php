<?php

namespace App\Shared\Domain;

final class Timestamps
{
    use Timestampable;

    public function __construct(private \DateTime $createdAt, private \DateTime $updatedAt)
    {
    }
}
