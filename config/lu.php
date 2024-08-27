<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/fr.lu%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'public' => 'Jour férié',
    'filter' => static function ($date, $name) {
        $ignore = ['Vendredi saint'];
        if (in_array($name, $ignore, true)) {
            return  false;
        }

        return $name;
    },
];
