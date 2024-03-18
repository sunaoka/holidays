<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/zh-tw.taiwan%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'public' => '國定假日',
    'filter' => static function ($date, $name) {
        return $name;
    },
];
