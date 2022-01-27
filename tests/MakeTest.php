<?php

namespace Sunaoka\Holidays\Tests;

use Sunaoka\Holidays\Task\Make;

class MakeTest extends TestCase
{
    public function testMakeSuccess()
    {
        $config = [
            'ical'   => __DIR__ . '/stubs/stub.ics',
            'filter' => static function ($date, $name) {
                return $name;
            },
        ];

        $holiday = Make::holiday($config);

        self::assertSame([
            '2021-01-01' => 'New Year\'s Day',
            '2021-12-25' => 'Christmas Day',
        ], $holiday);
    }
}
