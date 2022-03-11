<?php

namespace App\Blog\Shared\UI\Http;

use App\Shared\UI\Http\WebController;
use Symfony\Component\HttpFoundation\Response;

final class BlogController extends WebController
{
    public function __invoke(): Response
    {
        return $this->render('@Blog/blog.html.twig');
    }
}
