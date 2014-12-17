<?php

namespace Ei\Calendar\Resolution;

use DateTime;
use Ei\Calendar\ResolutionInterface;
use Ei\Calendar\Week;


class WeekResolution implements ResolutionInterface
{

    protected $currentDate;


    protected $startDay = 'Monday';


    public function __construct($startDay = null)
    {
        if ($startDay !== null) {
            $this->setStartDay($startDay);
        }
    }

    public function setStartDay($startDay)
    {
        $this->startDay = $startDay;
        return $this;
    }

    public function startDay()
    {
        return $this->startDay;
    }

    public function setDateTime(DateTime $dateTime)
    {
        $this->currentDate = $dateTime;
        return $this;
    }

    public function dateTime()
    {
        return $this->currentDate;
    }

    public function build()
    {
        if ($this->currentDate === null) {
            return null;
        }
        return new Week($this->currentDate, $this->startDay);
    }
}
