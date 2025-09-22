<?php

namespace Sunaoka\Holidays\Tests;

use Sunaoka\Holidays\Task\Make;

/**
 * @phpstan-import-type Config from Make
 */
class MakeTest extends TestCase
{
    /**
     * @return void
     */
    public function testMakeSuccess()
    {
        /** @var Config $config */
        $config = [
            'ical'   => __DIR__ . '/stubs/stub.ics',
            'public' => 'Public holiday',
            'filter' => static function ($date, $name) {
                $ignore = ['Wrong Public Holidays'];
                if (in_array($name, $ignore, true)) {
                    return false;
                }

                return $name;
            },
        ];

        $holiday = Make::holiday($config);

        self::assertSame([
            '2024-01-01' => 'New Year\'s Day',
            '2024-01-15' => 'Martin Luther King Jr. Day',
        ], $holiday);
    }
}
