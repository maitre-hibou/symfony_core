<?php

namespace App\Shared\Domain\Bus\Query\Exception;

use App\Shared\Domain\Bus\Query\Query;

final class QueryNotRegisteredError extends \RuntimeException
{
    public function __construct(Query $query)
    {
        parent::__construct(sprintf('Query <%s> has no handler associated.', get_class($query)));
    }
}
