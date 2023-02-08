<?php

namespace Sunaoka\Holidays\Tests;

use Sunaoka\Holidays\Holiday;

class HolidayTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetDate()
    {
        $actual = new Holiday('2022-01-01', "New Year's Day");
        self::assertSame('2022-01-01', $actual->getDate());
    }

    /**
     * @return void
     */
    public function testGetName()
    {
        $actual = new Holiday('2022-01-01', "New Year's Day");
        self::assertSame('New Year\'s Day', $actual->getName());
    }

    /**
     * @return void
     */
    public function testToString()
    {
        $actual = new Holiday('2022-01-01', "New Year's Day");
        self::assertSame('2022-01-01', (string)$actual);
    }
}
