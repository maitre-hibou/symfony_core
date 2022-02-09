<?php

namespace App\Shared\Domain;

use ArrayIterator;
use Countable;
use IteratorAggregate;

abstract class Collection implements Countable, IteratorAggregate
{
    public function __construct(private array $items = [])
    {
        Assert::arrayOf($this->type(), $items);
    }

    public function count(): int
    {
        return count($this->items());
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    protected function items(): array
    {
        return $this->items;
    }

    abstract protected function type(): string;
}
