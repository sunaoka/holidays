<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/zh.china%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'public' => '公众假期',
    'filter' => static function ($date, $name) {
        $ignore = [];
        if (in_array($name, $ignore, true)) {
            return  false;
        }

        return $name;
    },
];
