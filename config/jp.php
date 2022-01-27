<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/ja.japanese%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'filter' => static function ($date, $name) {
        if ($name === '体育の日' && (int)date('Y', strtotime($date)) >= 2020) {
            return 'スポーツの日';
        }
        return $name;
    },
];
