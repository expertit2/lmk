<?php

namespace Ei\Calendar;

use DateTime;


class Day implements TimeframeInterface
{

    protected $today;


    protected $isOverflow = false;


    public function __construct(DateTime $date)
    {
        $this->today = clone $date; // take a copy just to be safe.
    }


    public function date()
    {
        return $this->today;
    }

    public function setIsOverflow($isOverflow)
    {
        $this->isOverflow = $isOverflow;
    }


    public function isOverflow()
    {
        return $this->isOverflow;
    }


    public function start()
    {
        return new DateTime($this->today->format('Y-m-d 00:00:00'));
    }

    public function end()
    {
        return new DateTime($this->today->format('Y-m-d 23:59:59'));
    }
}
