<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/zh-hk.hong_kong%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'filter' => static function ($date, $name) {
        return $name;
    },
];
