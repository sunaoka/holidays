<?php

namespace Sunaoka\Holidays\Tests;

use Carbon\Carbon;
use DateTime;
use Sunaoka\Holidays\Exceptions\UnsupportedCountryException;
use Sunaoka\Holidays\Holiday;
use Sunaoka\Holidays\Holidays;

class HolidaysTest extends TestCase
{
    public function testUnsupportedCountry()
    {
        $this->expectExceptionCompat(UnsupportedCountryException::class);

        new Holidays('ZZ');
    }

    public function testIsHolidaySuccess()
    {
        $holidays = new Holidays('US');

        $actual = $holidays->isHoliday(date('Y-01-01'));
        self::assertTrue($actual, 'date only (string)');

        $actual = $holidays->isHoliday(date('Y-01-01 H:i:s'));
        self::assertTrue($actual, 'date time (string)');

        $actual = $holidays->isHoliday(new DateTime(date('Y-01-01')));
        self::assertTrue($actual, 'date only (DateTime)');

        $actual = $holidays->isHoliday(new DateTime(date('Y-01-01 H:i:s')));
        self::assertTrue($actual, 'date time (DateTime)');

        $actual = $holidays->isHoliday(Carbon::parse(date('Y-01-01')));
        self::assertTrue($actual, 'date only (Carbon)');

        $actual = $holidays->isHoliday(Carbon::parse(date('Y-01-01 H:i:s')));
        self::assertTrue($actual, 'date time (Carbon)');
    }

    public function testGetHolidaysSuccess()
    {
        $year = (int)date('Y');

        $holidays = new Holidays('US');
        $actual = $holidays->getHolidays();

        $this->assertIsArrayCompat($actual);
        $this->assertInstanceOf(Holiday::class, $actual[0]);

        $actual = $holidays->getHolidays($year);

        $this->assertIsArrayCompat($actual);
        foreach ($actual as $holiday) {
            self::assertSame($year, (int)$holiday->format('Y'));
        }

        $actual = $holidays->getHolidays($year, 1);
        $this->assertIsArrayCompat($actual);
        foreach ($actual as $holiday) {
            self::assertSame($year, (int)$holiday->format('Y'));
            self::assertSame(1, (int)$holiday->format('m'));
        }

        self::assertSame("New Year's Day", $actual[0]->getName());
    }

    public function testBetweenSuccess()
    {
        $holidays = new Holidays('US');

        $actual = $holidays->between(date('Y-01-01'), date('Y-01-07'));
        $this->assertIsArrayCompat($actual);
        $this->assertInstanceOf(Holiday::class, $actual[0]);

        self::assertCount(1, $actual);

        $actual = $holidays->between(date('Y-01-01 12:34:56'), date('Y-01-07 12:35:56'));
        $this->assertIsArrayCompat($actual);
        $this->assertInstanceOf(Holiday::class, $actual[0]);

        self::assertCount(1, $actual);

        $actual = $holidays->between(date('Y-01-07'), date('Y-01-01'));
        $this->assertIsArrayCompat($actual);
        $this->assertInstanceOf(Holiday::class, $actual[0]);

        self::assertCount(1, $actual);
    }

    public function testAddHoliday()
    {
        $holidays = new Holidays('US');

        $holidays->addHoliday(new Holiday('1970-01-01', 'The Unix epoch'));

        $actual = $holidays->isHoliday('1970-01-01');
        self::assertTrue($actual);

        $actual = $holidays->getHolidays();
        self::assertSame('1970-01-01', $actual[0]->getDate());
        self::assertSame('The Unix epoch', $actual[0]->getName());
    }

    public function testAddHolidays()
    {
        $holidays = new Holidays('US');

        $holidays->addHolidays([new Holiday('1970-01-01', 'The Unix epoch')]);

        $actual = $holidays->isHoliday('1970-01-01');
        self::assertTrue($actual);

        $actual = $holidays->getHolidays();
        self::assertSame('1970-01-01', $actual[0]->getDate());
        self::assertSame('The Unix epoch', $actual[0]->getName());
    }
}
