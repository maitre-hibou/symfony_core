<?php

namespace App\Shared\Infrastructure\Symfony\Http;

use App\Shared\Infrastructure\Http\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

interface WebController extends Controller
{
    public function render(string $templateName, array $arguments = []): Response;

    public function redirectTo(string $routeName, array $routeParams = [], int $redirectStatus = Response::HTTP_FOUND): RedirectResponse;
}
