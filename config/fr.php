<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/fr.french%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'public' => 'Jour férié',
    'filter' => static function ($date, $name) {
        return $name;
    },
];
