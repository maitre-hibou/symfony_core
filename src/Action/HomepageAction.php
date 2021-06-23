<?php

namespace App\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class HomepageAction
{
    public function __construct(private Environment $twig)
    {
    }

    public function __invoke(Request $request): Response
    {
        return new Response($this->twig->render('homepage.html.twig'));
    }
}
