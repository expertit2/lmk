<?php

namespace Ei\Calendar;

use DateTime;


class Month implements TimeframeInterface
{

    protected $startDateTime;


    protected $endDateTime;


    protected $numDays = 31;


    protected $year;


    protected $weeks = array();


    public function __construct(DateTime $pointWithinMonth)
    {
        $year = $pointWithinMonth->format('Y');
        $month = $pointWithinMonth->format('m');

        $startDate = $year.'-'.$month.'-01';
        $this->startDateTime = new DateTime($startDate);

        $this->numDays = (int)$this->startDateTime->format('t');

        $endDate = $year.'-'.$month.'-'.str_pad($this->numDays, 2, '0', STR_PAD_LEFT);
        $this->endDateTime = new DateTime($endDate);
    }


    public function firstDay()
    {
        return $this->startDateTime;
    }


    public function lastDay()
    {
        return $this->endDateTime;
    }


    public function numDays()
    {
        return $this->numDays;
    }


    public function year()
    {
        if (!isset($this->year)) {
            $this->year = new Year($this->startDateTime->format('Y'));
        }
        return $this->year;
    }


    public function prev($offset = 1)
    {
        $prevDateTime = clone $this->startDateTime;
        $prevDateTime->modify('-'.abs($offset).' months');
        return new Month($prevDateTime);
    }

    public function next($offset = 1)
    {
        $nextDateTime = clone $this->startDateTime;
        $nextDateTime->modify('+'.abs($offset).' months');
        return new Month($nextDateTime);
    }


    public function weeks($startDay = 'Monday')
    {
        if (!isset($this->weeks[$startDay])) {
            $this->weeks[$startDay] = array();
            $keepWeeking = true;
            $weekPoint = clone $this->firstDay();

            while ($keepWeeking) {
                $candidateWeek = new Week($weekPoint, $startDay);
                if ($candidateWeek->weekStart() <= $this->lastDay()) {
                    $candidateWeek->setContainingMonth($this);
                    $this->weeks[$startDay][] = $candidateWeek;
                    $weekPoint->modify('+1 week');
                } else {
                    $keepWeeking = false;
                }
            }
        }
        return $this->weeks[$startDay];
    }


    public function title($format)
    {
        return $this->firstDay()->format($format);
    }


    public function start()
    {
        return new DateTime($this->firstDay()->format('Y-m-d 00:00:00'));
    }

    public function end()
    {
        return new DateTime($this->lastDay()->format('Y-m-d 23:59:59'));
    }
}
