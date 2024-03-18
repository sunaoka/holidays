<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/de.german%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'public' => 'Feiertag',
    'filter' => static function ($date, $name) {
        return $name;
    },
];
