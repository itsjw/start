<?php

namespace Perfumerlabs\Start\Service;

use Perfumerlabs\Start\Service\Activity\AbstractActivity;

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