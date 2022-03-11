<?php

namespace App\Tests\Application\Blog\Shared\UI\Http;

use App\Tests\Shared\Infrastructure\Symfony\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

final class BlogControllerTest extends WebTestCase
{
    public function testHomePageIsShown(): void
    {
        $this->client->request(Request::METHOD_GET, '/blog');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'The Blog');
    }
}
