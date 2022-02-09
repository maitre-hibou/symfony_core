<?php

namespace App\Tests\Unit\Shared\Infrastructure;

use App\Shared\Infrastructure\RandomNumberGenerator;
use PHPUnit\Framework\TestCase;

final class RandomNumberGeneratorTest extends TestCase
{
    private RandomNumberGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new RandomNumberGenerator();
    }

    public function testUuidGenerationIsValid(): void
    {
        $this->assertIsInt($this->generator->generate());
    }
}
