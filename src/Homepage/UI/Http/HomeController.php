<?php

namespace App\Homepage\UI\Http;

use App\Homepage\Application\Find\RandomQuoteQuery;
use App\Homepage\Application\Find\RandomQuoteResponse;
use App\Shared\UI\Http\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HomeController extends WebController
{
    public function __invoke(Request $request): Response
    {
        /** @var RandomQuoteResponse $randomQuoteResponse */
        $randomQuoteResponse = $this->queryBus->ask(new RandomQuoteQuery());

        return $this->render('@Homepage/home.html.twig', [
            'quote' => $randomQuoteResponse->quote(),
        ]);
    }
}
