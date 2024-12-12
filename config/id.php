<?php

return [
    'ical'   => 'https://calendar.google.com/calendar/ical/id.indonesian%23holiday%40group.v.calendar.google.com/public/basic.ics',
    'public' => 'Hari libur nasional',
    'filter' => static function ($date, $name) {
        $ignore = [];
        if (in_array($name, $ignore, true)) {
            return false;
        }

        return $name;
    },
];
