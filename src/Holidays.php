<?php

namespace Sunaoka\Holidays;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Sunaoka\Holidays\Exceptions\UnsupportedCountryException;

class Holidays
{
    /**
     * @var array
     */
    protected $holidays;

    /**
     * @param string $country Country
     *
     * @throws UnsupportedCountryException
     */
    public function __construct($country)
    {
        $country = strtolower($country);
        $this->loadHolidays($country);
    }

    /**
     * Finds whether a date is a holiday
     *
     * @param DateTimeInterface|string $date Date
     *
     * @return bool
     */
    public function isHoliday($date)
    {
        return isset($this->holidays[$this->resolveHoliday($date)->format('Y-m-d')]);
    }

    /**
     * Returns a list of holidays
     *
     * @param int $year  Year of Holidays
     * @param int $month Month of Holidays
     *
     * @return array
     */
    public function getHolidays($year = null, $month = null)
    {
        if ($year !== null && $month !== null) {
            $startDate = new DateTimeImmutable("{$year}-{$month}-01");
            $endDate = $startDate->modify('last day of');
            $holidays = $this->filter($startDate, $endDate);
        } elseif ($year !== null) {
            $startDate = new DateTimeImmutable("{$year}-01-01");
            $endDate = new DateTimeImmutable("{$year}-12-31");
            $holidays = $this->filter($startDate, $endDate);
        } else {
            $holidays = $this->holidays;
        }

        return array_values($holidays);
    }

    /**
     * Returns holidays for a given date range.
     *
     * @param DateTimeInterface|string $start The start date
     * @param DateTimeInterface|string $end   The end date
     *
     * @return array
     */
    public function between($start, $end)
    {
        $startDate = $this->resolveHoliday($start);
        $endDate = $this->resolveHoliday($end);

        if ($startDate > $endDate) {
            list($endDate, $startDate) = [$startDate, $endDate];
        }

        $holidays = $this->filter($startDate->setTime(0, 0, 0), $endDate->setTime(23, 59, 59));

        return array_values($holidays);
    }

    /**
     * Add custom holiday
     *
     * @param Holiday $holiday
     *
     * @return void
     */
    public function addHoliday(Holiday $holiday)
    {
        $this->holidays[$holiday->getDate()] = $holiday;
        ksort($this->holidays);
    }

    /**
     * Add custom holidays
     *
     * @param Holiday[] $holidays
     *
     * @return void
     */
    public function addHolidays($holidays)
    {
        foreach ($holidays as $holiday) {
            $this->holidays[$holiday->getDate()] = $holiday;
        }
        ksort($this->holidays);
    }

    /**
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface $endDate
     *
     * @return array
     */
    protected function filter(DateTimeInterface $startDate, DateTimeInterface $endDate)
    {
        return array_filter($this->holidays, static function (Holiday $date) use ($startDate, $endDate) {
            return $startDate <= $date && $date <= $endDate;
        });
    }

    /**
     * @param string $country
     *
     * @return void
     *
     * @throws UnsupportedCountryException
     */
    protected function loadHolidays($country)
    {
        if ($this->holidays === null) {
            $file = __DIR__ . "/data/{$country}.php";
            if (!file_exists($file)) {
                throw new UnsupportedCountryException("Country '{$country}' is not a valid country.");
            }
            $this->holidays = include($file);
        }
    }

    /**
     * @param DateTimeInterface|string $date
     *
     * @return DateTimeInterface
     */
    protected function resolveHoliday($date)
    {
        if ($date instanceof DateTimeInterface) {
            return $date;
        }

        try {
            return new DateTimeImmutable($date);
        } catch (Exception $e) {                  // @codeCoverageIgnore
            return new DateTimeImmutable('now');  // @codeCoverageIgnore
        }
    }
}
