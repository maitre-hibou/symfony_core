<?php

namespace App\Shared\Infrastructure\Twig\Extension;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class UrlExtension extends AbstractExtension
{
    public function __construct(private RouterInterface $router)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('safe_url', [$this, 'safeUrl']),
        ];
    }

    public function safeUrl(string $routeName, array $arguments = []): ?string
    {
        try {
            $url = $this->router->generate($routeName, $arguments);

            return $url;
        } catch (RouteNotFoundException) {
            return null;
        }
    }
}
