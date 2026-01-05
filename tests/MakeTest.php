<?php

namespace Sunaoka\Holidays\Tests;

use Sunaoka\Holidays\Task\Make;

/**
 * @phpstan-import-type Config from Make
 */
class MakeTest extends TestCase
{
    /**
     * @return string
     */
    private function getStub()
    {
        $stub = (string)file_get_contents(__DIR__ . '/stubs/stub.ics');

        return str_replace([
            '2022',
            '2023',
            '2024',
        ], [
            $this->year(-2),
            $this->year(-1),
            $this->year(),
        ], $stub);
    }

    /**
     * @param int $offset
     *
     * @return string
     */
    private function year($offset = 0)
    {
        /** @var ?int $year */
        static $year;
        if ($year === null) {
            $year = date('Y');
        }

        return (string)($year + $offset);
    }

    /**
     * @return void
     */
    public function testMakeSuccess()
    {
        /** @var Config $config */
        $config = [
            'ical'   => 'data://text/plain;base64,' . base64_encode($this->getStub()),
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
            "{$this->year()}-01-01" => 'New Year\'s Day',
            "{$this->year()}-01-15" => 'Martin Luther King Jr. Day',
        ], $holiday);
    }
}
