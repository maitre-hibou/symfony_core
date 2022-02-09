<?php

namespace App\Shared\Domain\Bus\Event;

use DateTimeImmutable;
use App\Shared\Domain\Utils\Dates;
use App\Shared\Domain\ValueObject\Uuid;

abstract class DomainEvent
{
    private string $eventId;

    private string $occuredOn;

    public function __construct(private string $aggregateId, string $eventId = null, string $occuredOn = null)
    {
        $this->eventId = $eventId ?: Uuid::random()->value();
        $this->occuredOn = $occuredOn ?: Dates::dateToString(new DateTimeImmutable());
    }

    abstract public static function eventName(): string;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occuredOn(): string
    {
        return $this->occuredOn;
    }
}
