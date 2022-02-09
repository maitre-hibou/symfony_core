<?php

namespace App\Shared\Infrastructure\Bus\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;
use App\Shared\Domain\Bus\Event\EventBus;

final class InMemoryEventBus implements EventBus
{
    public function publish(DomainEvent ...$events): void
    {
    }
}
