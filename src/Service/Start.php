<?php

namespace Perfumerlabs\Start\Service;

use App\Model\User;
use App\Model\UserRoleQuery;
use Perfumerlabs\Start\Model\ActivityAccessQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class Start
{
    public function getAllowedActivities(User $user)
    {
        $role_ids = UserRoleQuery::create()
            ->filterByUser($user)
            ->select('role_id')
            ->find()
            ->getData();

        $activity_ids = ActivityAccessQuery::create()
            ->filterByRoleId($role_ids, Criteria::IN)
            ->_or()
            ->filterByUser($user)
            ->select('activity_id')
            ->find()
            ->getData();

        return $activity_ids;
    }
}
