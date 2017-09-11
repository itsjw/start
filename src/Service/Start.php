<?php

namespace Perfumerlabs\Start\Service;

use App\Model\User;
use Perfumerlabs\Start\Model\ScheduleQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class Start
{
    public function getAllowedActivities(User $user)
    {
        $roles = $user->getRoles();
        $activities = [];

        if (count($roles) > 0) {
            $activities = ScheduleQuery::create()
                ->filterByRoleId($roles->getPrimaryKeys(), Criteria::IN)
                ->select('activity_id')
                ->find()
                ->getData();
        }

        return array_unique($activities);
    }
}
