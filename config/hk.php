<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/zh-hk.hong_kong%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'public' => 'Public holiday',
    'filter' => static function ($date, $name) {
        $ignore = [];
        if (in_array($name, $ignore, true)) {
            return  false;
        }

        return $name;
    },
];
