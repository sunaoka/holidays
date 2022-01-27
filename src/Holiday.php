<?php

namespace Sunaoka\Holidays;

use DateTimeImmutable;
use Exception;

class Holiday extends DateTimeImmutable
{
    /**
     * Name of the holiday
     *
     * @var string
     */
    protected $name;

    /**
     * @param string $datetime Date of holiday
     * @param string $name     Name of the holiday
     *
     * @throws Exception
     */
    public function __construct($datetime, $name)
    {
        parent::__construct($datetime);
        $this->name = $name;
    }

    /**
     * @param array $array
     *
     * @return self
     *
     * @throws Exception
     */
    #[\ReturnTypeWillChange]
    public static function __set_state($array)
    {
        return new self($array['date'], $array['name']);
    }

    /**
     * Get date of the holiday
     *
     * @return string
     */
    public function getDate()
    {
        return $this->format('Y-m-d');
    }

    /**
     * Get name of the holiday
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getDate();
    }
}
