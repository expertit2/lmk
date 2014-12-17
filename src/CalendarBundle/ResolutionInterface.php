<?php

namespace Ei\Calendar;

use DateTime;


interface ResolutionInterface
{

    public function setDateTime(DateTime $dateTime);


    public function dateTime();

    public function build();
}
