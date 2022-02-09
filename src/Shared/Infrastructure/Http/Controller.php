<?php

namespace App\Shared\Infrastructure\Http;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\Response;

interface Controller
{
    public function ask(Query $query): ?Response;

    public function dispatch(Command $command): void;
}
