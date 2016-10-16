<?php

namespace Start\Service;

class Activity
{
    public function close(\App\Model\Activity $activity)
    {
        $activity->setClosedAt(new \DateTime());
        $activity->save();
    }
}