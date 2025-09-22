<?php

namespace Sunaoka\Holidays\Task;

/**
 * @phpstan-type Config array{
 *     ical: string,
 *     public: string,
 *     filter: callable(string, string): (string|false)
 * }
 */
class Make
{
    /**
     * @param Config $config
     *
     * @return array<string, string>
     */
    public static function holiday($config)
    {
        $start = new \DateTimeImmutable('first day of January last year');
        $end = new \DateTimeImmutable('last day of December next year');

        $ical = (string)file_get_contents($config['ical']);

        $holiday = [];
        $pattern = '/DTSTART;VALUE=DATE:(?<date>\d{8})[\s\S]*DESCRIPTION:(?<description>.+?)[\s\S]*SUMMARY:(?<name>.+?)/Um';
        if (preg_match_all($pattern, $ical, $m, PREG_PATTERN_ORDER) !== false) {
            foreach ($m['date'] as $index => $date) {
                $datetime = \DateTimeImmutable::createFromFormat('Ymd', $date);
                if ($datetime === false) {
                    throw new \RuntimeException('Invalid date');
                }

                $ymd = $datetime->modify('today')->format('Y-m-d');
                if ($datetime < $start || $datetime > $end) {
                    continue;
                }

                // To hide observances, go to Google Calendar Settings > Holidays in United States
                if (strpos($m['description'][$index], 'Google') !== false) {
                    continue;
                }

                if (strpos($m['description'][$index], $config['public']) === false) {
                    continue;
                }

                $name = $config['filter']($ymd, trim($m['name'][$index]));
                if ($name === false) {
                    continue;
                }

                $holiday[$ymd] = $name;
            }
        }
        ksort($holiday);

        return $holiday;
    }
}
