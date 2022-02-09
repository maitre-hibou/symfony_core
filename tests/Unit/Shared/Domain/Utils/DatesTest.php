<?php

namespace App\Tests\Unit\Shared\Domain\Utils;

use App\Shared\Domain\Utils\Dates;
use DateTime;
use PHPUnit\Framework\TestCase;

final class DatesTest extends TestCase
{
    public function testDateToStringMethod(): void
    {
        $date = new DateTime('2022-02-10');

        $this->assertEquals('2022-02-10T00:00:00+00:00', Dates::dateToString($date));
    }
}
