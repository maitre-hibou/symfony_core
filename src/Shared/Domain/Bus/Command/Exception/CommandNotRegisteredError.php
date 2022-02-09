<?php

namespace App\Shared\Domain\Bus\Command\Exception;

use App\Shared\Domain\Bus\Command\Command;

final class CommandNotRegisteredError extends \RuntimeException
{
    public function __construct(Command $command)
    {
        parent::__construct(sprintf('Command <%s> has no registered handler.', get_class($command)));
    }
}
