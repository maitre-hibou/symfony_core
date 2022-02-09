<?php

namespace App\Shared\UI\Http;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\Response;
use App\Shared\Infrastructure\Http\Controller;

abstract class AbstractController implements Controller
{
    public function __construct(protected QueryBus $queryBus, protected CommandBus $commandBus)
    {
    }

    public function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
