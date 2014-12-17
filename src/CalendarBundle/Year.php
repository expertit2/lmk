<?php

namespace Ei\Calendar;

use DateTime;
use Exception;
use Ei\Calendar\Exception\Date as DateException;


class Year implements TimeframeInterface
{

    protected $newYearsDay;


    public function __construct($year)
    {
        try {
            $this->newYearsDay = new DateTime($year.'-01-01');
        } catch (Exception $e) {
            throw new DateException($e->getMessage(), DateException::INVALID_DATE, $e);
        }
    }


    public function yearFull()
    {
        return $this->newYearsDay->format('Y');
    }


    public function yearShort()
    {
        return $this->newYearsDay->format('y');
    }


    public function isLeapYear()
    {
        return (bool)$this->newYearsDay->format('L');
    }


    public function start()
    {
        return new DateTime($this->newYearsDay->format('Y-01-01 00:00:00'));
    }

    public function end()
    {
        return new DateTime($this->newYearsDay->format('Y-12-31 23:59:59'));
    }
}
