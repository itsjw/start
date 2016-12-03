<?php

namespace Perfumerlabs\Start\Service;

class Activity
{
    public function close(\Perfumerlabs\Start\Model\Activity $activity)
    {
        $activity->setClosedAt(new \DateTime());
        $activity->save();
    }
}