<?php

namespace App\Shared\UI\Http;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Infrastructure\Symfony\Http\WebController as WebControllerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

abstract class WebController extends AbstractController implements WebControllerInterface
{
    public function __construct(
        private Environment $twig,
        private RouterInterface $router,
        QueryBus $queryBus,
        CommandBus $commandBus
    ) {
        parent::__construct($queryBus, $commandBus);
    }

    public function render(string $templateName, array $arguments = [], int $httpStatusCode = Response::HTTP_OK): Response
    {
        return new Response(
            $this->twig->render($templateName, $arguments),
            $httpStatusCode
        );
    }

    public function redirectTo(string $routeName, array $routeParams = [], int $redirectStatus = Response::HTTP_FOUND): RedirectResponse
    {
        return new RedirectResponse($this->router->generate($routeName, $routeParams), $redirectStatus);
    }
}
