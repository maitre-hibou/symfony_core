<?php

namespace App\Shared\Domain;

trait Timestampable
{
    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function prePersistTimestamps(): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;
    }

    public function preUpdateTimestamps(): void
    {
        $this->updatedAt = new \DateTime();
    }
}
