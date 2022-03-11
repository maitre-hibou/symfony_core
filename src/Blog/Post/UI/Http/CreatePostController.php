<?php

namespace App\Blog\Post\UI\Http;

use App\Shared\UI\Http\WebController;

final class CreatePostController extends WebController
{
    public function __invoke()
    {
        return $this->render('@BlogPost/create.html.twig');
    }
}
