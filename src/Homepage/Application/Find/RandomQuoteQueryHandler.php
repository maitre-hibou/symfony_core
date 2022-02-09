<?php

namespace App\Homepage\Application\Find;

use App\Homepage\Domain\QuoteRepository;
use App\Shared\Domain\Bus\Query\QueryHandler;

final class RandomQuoteQueryHandler implements QueryHandler
{
    public function __construct(private QuoteRepository $quoteRepository)
    {
    }

    public function __invoke(RandomQuoteQuery $query): RandomQuoteResponse
    {
        return new RandomQuoteResponse(
            $this->quoteRepository->random()
        );
    }
}
