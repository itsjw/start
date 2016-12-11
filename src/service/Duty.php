<?php

namespace Perfumerlabs\Start\Service;

class Duty
{
    /**
     * @param \Perfumerlabs\Start\Model\Duty $duty
     * @return bool
     */
    public function close(\Perfumerlabs\Start\Model\Duty $duty)
    {
        $duty->setClosedAt(new \DateTime());

        return (bool) $duty->save();
    }

    /**
     * @param \Perfumerlabs\Start\Model\Duty $duty
     * @param \DateTime $date
     * @return bool
     */
    public function postpone(\Perfumerlabs\Start\Model\Duty $duty, \DateTime $date)
    {
        if ($duty->getClosedAt()) {
            return false;
        } else {
            $duty->setRaisedAt($date);
            $duty->setPickedAt(null);

            return (bool) $duty->save();
        }
    }
}