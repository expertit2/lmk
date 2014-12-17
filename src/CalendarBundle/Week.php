<?php

namespace Ei\Calendar;

use DateTime;


class Week implements TimeframeInterface
{

    protected $weekStart;


    protected $weekEnd;


    protected $containingMonth = null;


    protected $days;


    public function __construct(DateTime $pointWithinWeek, $startDay = 'Monday')
    {
        // Work out the start of the week:
        $this->weekStart = clone $pointWithinWeek;
        if ($this->weekStart->format('l') != $startDay) {
            // We're not on the first day, so move backwards:
            $this->weekStart->modify('previous '.$startDay);
        }

        // And now the end of the week is just 6 days on:
        $this->weekEnd = clone $this->weekStart;
        $this->weekEnd->modify('+6 days');

    }


    public function weekStart()
    {
        return $this->weekStart;
    }


    public function weekEnd()
    {
        return $this->weekEnd;
    }


    public function setContainingMonth(Month $containingMonth)
    {
        $this->containingMonth = clone $containingMonth;
        return $this;
    }


    public function containingMonth()
    {
        return $this->containingMonth;
    }

    public function days()
    {
        if (!isset($this->days)) {
            $clonedStart = clone $this->weekStart;
            $this->days = array();
            for ($i = 0; $i < 7; $i ++) {
                $thisDay = new Day($clonedStart);

                if (
                    $this->containingMonth
                    && $this->containingMonth->firstDay()->format('m') != $clonedStart->format('m')
                ) {
                    $thisDay->setIsOverflow(true);
                }

                $this->days[] = $thisDay;
                $clonedStart->modify('+1 day');
            }
        }
        return $this->days;
    }


    public function start()
    {
        return new DateTime($this->weekStart()->format('Y-m-d 00:00:00'));
    }


    public function end()
    {
        return new DateTime($this->weekEnd()->format('Y-m-d 23:59:59'));
    }
}
