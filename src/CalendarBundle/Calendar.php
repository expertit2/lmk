<?php

namespace Ei\Calendar;

use DateTime;

class Calendar
{

    protected $currentDateTime;


    protected $resolution;


    protected $events = array();


    public function __construct(DateTime $dateTime = null)
    {
        if ($dateTime !== null) {
            $this->setCurrentDate($dateTime);
        }
    }


    public function setCurrentDate(DateTime $dateTime)
    {
        $this->currentDateTime = clone $dateTime;
        return $this;
    }


    public function currentDate()
    {
        return $this->currentDateTime;
    }

    public function setResolution(ResolutionInterface $res)
    {
        $this->resolution = $res;
        $this->resolution->setDateTime($this->currentDate());
        return $this;
    }

    public function resolution()
    {
        return $this->resolution;
    }


    public function addEvent(EventInterface $event)
    {
        $this->events[] = $event;
        return $this;
    }


    public function events()
    {
        return $this->events;
    }

    public function eventsForTimeframe(TimeframeInterface $timeframe)
    {
        $events = array();

        foreach ($this->events as $event) {
            // Check if the start occurs within the timeframe:
            if ($event->start() >= $timeframe->start() && $event->start() <= $timeframe->end()) {
                $events[$event->start()->getTimestamp()] = $event;
            } elseif ($event->end() >= $timeframe->start() && $event->end() <= $timeframe->end()) {
                $events[$event->start()->getTimestamp()] = $event;
            }
        }

        // Sort by the keys and then return only the values:
        ksort($events);

        return array_values($events);
    }


    public function viewData()
    {
        $resolutionData = $this->resolution->build();
        return array(
            'contents' => $resolutionData
        );
    }
}
