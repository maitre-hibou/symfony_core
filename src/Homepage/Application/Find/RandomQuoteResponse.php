<?php

namespace App\Homepage\Application\Find;

use App\Homepage\Domain\Quote;
use App\Shared\Domain\Bus\Query\Response;

final class RandomQuoteResponse implements Response
{
    public function __construct(private Quote $quote)
    {
    }

    public function quote(): Quote
    {
        return $this->quote;
    }
}
