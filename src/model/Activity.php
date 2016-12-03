<?php

namespace Perfumerlabs\Start\Model;

use Perfumerlabs\Start\Model\Base\Activity as BaseActivity;
use Propel\Runtime\Connection\ConnectionInterface;

/**
 * Skeleton subclass for representing a row from the 'activity' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Activity extends BaseActivity
{
    public function preSave(ConnectionInterface $con = null)
    {
        if ($this->getPriority() > 10) {
            $this->setPriority(10);
        }

        if ($this->getPriority() < 1) {
            $this->setPriority(1);
        }

        return true;
    }

}
