<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/en.usa%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'filter' => static function ($date, $name) {
        return $name;
    },
];
