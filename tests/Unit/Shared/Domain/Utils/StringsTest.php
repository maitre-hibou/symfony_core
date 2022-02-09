<?php

namespace App\Tests\Unit\Shared\Domain\Utils;

use App\Shared\Domain\Utils\Strings;
use PHPUnit\Framework\TestCase;

final class StringsTest extends TestCase
{
    public function testSanitizeAccentsMethod(): void
    {
        $test = 'C\'est l\'été, et à 18h, je prends un rosé pour l\'apérô';

        $this->assertEquals('C\'est l\'ete, et a 18h, je prends un rose pour l\'apero', Strings::sanitizeAccents($test));
    }

    public function testToCamelCaseMethod(): void
    {
        $this->assertEquals('symfonyIsTheBestPHPFramework', Strings::toCamelCase('Symfony is the best PHP framework !'));
        $this->assertEquals('symfonyIsTheBestPHPFramework', Strings::toCamelCase('Symfony is - the - best PHP framework !'));
        $this->assertEquals('symfonyIsTheBestPHPFramework', Strings::toCamelCase('Symfony is the best PHP_framework !'));
    }
}
