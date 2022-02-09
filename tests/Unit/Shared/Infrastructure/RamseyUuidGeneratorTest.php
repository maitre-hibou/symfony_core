<?php

namespace App\Tests\Unit\Shared\Infrastructure;

use App\Shared\Infrastructure\RamseyUuidGenerator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class RamseyUuidGeneratorTest extends TestCase
{
    private RamseyUuidGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new RamseyUuidGenerator();
    }

    public function testUuidGenerationIsValid(): void
    {
        $this->assertTrue(Uuid::isValid($this->generator->generate()));
    }
}
