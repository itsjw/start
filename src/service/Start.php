<?php

namespace Perfumerlabs\Start\Service;

use App\Model\User;
use Perfumerlabs\Start\Model\Schedule;
use Perfumerlabs\Start\Model\ScheduleQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class Start
{
    public function getAllowedActivities(User $user)
    {
        $roles = $user->getRoles();
        $activities = [];

        foreach ($roles as $role) {
            $date = date('Y-m-d');
            $week_day = date('N');
            $time = date('H:i:s');

            $schedules = ScheduleQuery::create()
                ->filterByRoleId($role->getId())
                ->filterByDate($date)
                ->filterByTimeFrom($time, Criteria::LESS_EQUAL)
                ->filterByTimeTo($time, Criteria::GREATER_EQUAL)
                ->find();

            if (count($schedules) == 0) {
                $schedules = ScheduleQuery::create()
                    ->filterByRoleId($role->getId())
                    ->filterByWeekDay($week_day)
                    ->filterByTimeFrom($time, Criteria::LESS_EQUAL)
                    ->filterByTimeTo($time, Criteria::GREATER_EQUAL)
                    ->find();
            }

            if (count($schedules) > 0) {
                foreach ($schedules as $schedule) {
                    /** @var Schedule $schedule */
                    $activities = array_merge($activities, $schedule->getActivities());
                }
            }
        }

        return array_unique($activities);
    }
}