<?php

namespace Ei\Calendar;

use DateTime;


class Timeframe implements TimeframeInterface
{

    protected $start;


    protected $end;


    public function __construct(DateTime $start, DateTime $end)
    {
        if ($end < $start) {
            throw new Exception\Timeframe(
                'End is before the start',
                Exception\Timeframe::INVALID_DATES
            );
        }

        $this->start = clone $start;
        $this->end = clone $end;
    }


    public function start()
    {
        return $this->start;
    }

    public function end()
    {
        return $this->end;
    }
}
