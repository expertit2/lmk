<?php

namespace Ei\Calendar\Resolution;

use DateTime;
use Ei\Calendar\ResolutionInterface;
use Ei\Calendar\Month;

class MonthResolution implements ResolutionInterface
{

    protected $currentDate;


    protected $monthOverflow = array('left' => 0, 'right' => 0);

    protected $daysOverflow = false;

    public function __construct($left = 0, $right = 0, $overflowDays = false)
    {
        $this->setMonthOverflow($left, $right);
        $this->setShowOverflowDays($overflowDays);
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

    public function setMonthOverflow($numLeft, $numRight)
    {
        $this->monthOverflow['left']    = (int)$numLeft;
        $this->monthOverflow['right']   = (int)$numRight;
        return $this;
    }

    public function monthOverflow()
    {
        return $this->monthOverflow;
    }

    public function setShowOverflowDays($useDaysOverflow)
    {
        $this->daysOverflow = (bool)$useDaysOverflow;
        return $this;
    }

    public function showOverflowDays()
    {
        return $this->daysOverflow;
    }

    public function build()
    {
        if (!isset($this->currentDate)) {
            return array();
        }

        // We need to know how many months to display, so that's the first job:
        $monthsToDisplay = array();
        $thisMonth = new Month($this->currentDate);

        // Go backwards first:
        for ($i = $this->monthOverflow['left']; $i != 0; $i --) {
            $monthsToDisplay[] = $thisMonth->prev($i);
        }

        // And the current:
        $monthsToDisplay[] = $thisMonth;

        // And then forwards:
        for ($i = 1; $i <= $this->monthOverflow['right']; $i ++) {
            $monthsToDisplay[] = $thisMonth->next($i);
        }

        return $monthsToDisplay;
    }
}
