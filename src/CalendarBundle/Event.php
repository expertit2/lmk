<?php

namespace Ei\Calendar;

use DateTime;
use Ei\Calendar\Exception\Event as EventException;


class Event implements EventInterface
{

    protected $start = false;


    protected $end = false;


    protected $title;

    public function __construct($title, DateTime $start, DateTime $end)
    {
        $this->setStart($start);
        $this->setEnd($end);
        $this->setTitle($title);
    }


    public function setStart(DateTime $start)
    {
        if ($this->end && $start > $this->end) {
            throw new EventException(
                'New start comes after the end!',
                EventException::INVALID_DATES
            );
        }
        $this->start = clone $start;
        return $this;
    }


    public function start()
    {
        return $this->start;
    }


    public function setEnd(DateTime $end)
    {
        // Check the end is not before the start:
        if ($this->start && $end < $this->start) {
            throw new EventException(
                'New end comes after the start!',
                EventException::INVALID_DATES
            );
        }

        $this->end = clone $end;
        return $this;
    }


    public function end()
    {
        return $this->end;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function title()
    {
        return $this->title;
    }
}
