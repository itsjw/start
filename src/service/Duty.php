<?php

namespace Perfumerlabs\Start\Service;

class Duty
{
    public function close(\Perfumerlabs\Start\Model\Duty $duty)
    {
        $duty->setClosedAt(new \DateTime());
        $duty->save();
    }
}