<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/en.singapore%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'public' => 'Public holiday',
    'filter' => static function ($date, $name) {
        return $name;
    },
];
