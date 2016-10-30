<?php

namespace App\Model;

use App\Model\Base\User as BaseUser;
use Perfumer\Component\Auth\UserHelpers;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Skeleton subclass for representing a row from the '_user' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class User extends BaseUser
{
    use UserHelpers;

    public function getActivityCodes()
    {
        $roles = $this->getRoles();
        $codes = [];

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
                    $codes = array_merge($codes, $schedule->getActivityCodes());
                }
            }
        }

        return array_unique($codes);
    }
}
