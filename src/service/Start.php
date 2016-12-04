<?php

namespace Perfumerlabs\Start\Service;

use Perfumerlabs\Start\Service\Activity\AbstractActivity;

class Start
{
    private $activities = [];

    public function addActivity(AbstractActivity $activity)
    {
        $this->activities[$activity->name] = $activity;
    }

    public function getActivity($name)
    {
        return $this->activities[$name];
    }
}