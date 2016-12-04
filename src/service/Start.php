<?php

namespace Perfumerlabs\Start\Service;

use App\Model\User;
use Perfumerlabs\Start\Model\Schedule;
use Perfumerlabs\Start\Model\ScheduleQuery;
use Perfumerlabs\Start\Service\Activity\AbstractActivity;
use Propel\Runtime\ActiveQuery\Criteria;

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

    public function getAllowedActivities(User $user)
    {
        $roles = $user->getRoles();
        $activities = [];

        foreach ($roles as $role) {
            $date = date('Y-m-d');
            $week_day = date('N');
            $time = date('H:i:s');

            $schedules = ScheduleQuery::create()
                ->filterByRole($role)
                ->filterByDate($date)
                ->filterByTimeFrom($time, Criteria::LESS_EQUAL)
                ->filterByTimeTo($time, Criteria::GREATER_EQUAL)
                ->find();

            if (count($schedules) == 0) {
                $schedules = ScheduleQuery::create()
                    ->filterByRole($role)
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