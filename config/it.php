<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/it.italian%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'public' => 'Festività pubblica',
    'filter' => static function ($date, $name) {
        return $name;
    },
];
