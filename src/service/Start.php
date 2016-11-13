<?php

namespace Start\Service;

use Start\Service\Activity\AbstractActivity;

class Start
{
    private $activities = [];

    public function addActivity(AbstractActivity $activity)
    {
        $this->activities[$activity->code] = $activity;
    }

    public function getActivity($code)
    {
        return $this->activities[$code];
    }
}