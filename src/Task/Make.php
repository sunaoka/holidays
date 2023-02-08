<?php

namespace Sunaoka\Holidays\Task;

class Make
{
    /**
     * @param array $config
     *
     * @return array
     */
    public static function holiday($config)
    {
        $ical = (string)file_get_contents($config['ical']);
        $holiday = [];
        $pattern = '/DTSTART;VALUE=DATE:(?<date>\d{8})[\s\S]*SUMMARY:(?<name>.+?)/Um';
        if (preg_match_all($pattern, $ical, $m, PREG_PATTERN_ORDER)) {
            foreach ($m['date'] as $index => $date) {
                $ymd = date('Y-m-d', (int)strtotime($date));
                $holiday[$ymd] = $config['filter']($ymd, trim($m['name'][$index]));
            }
        }
        ksort($holiday);

        return $holiday;
    }
}
