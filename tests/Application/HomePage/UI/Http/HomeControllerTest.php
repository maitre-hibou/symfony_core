<?php

namespace App\Tests\Application\Homepage\UI\Http;

use App\Tests\Shared\Infrastructure\Symfony\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

final class HomeControllerTest extends WebTestCase
{
    public function testHomePageIsShown(): void
    {
        $this->client->request(Request::METHOD_GET, '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World !');
    }
}
