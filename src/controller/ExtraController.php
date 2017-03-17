<?php

namespace Perfumerlabs\Start\Controller;

use App\Model\UserQuery;
use Perfumer\Framework\Controller\ViewController;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;
use Perfumerlabs\Start\Model\DutyQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class ExtraController extends ViewController
{
    use StatusViewControllerHelpers;

    public function get()
    {
        $picked_duties = DutyQuery::create()
            ->joinWith('Activity')
            ->filterByUserId((int) $this->getAuth()->getData())
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->filterByPickedAt(null, Criteria::ISNOTNULL)
            ->find();

        $highest_priority = 0;

        foreach ($picked_duties as $duty) {
            $duty_priority = $duty->getActivity()->getPriority();

            if ($duty_priority > $highest_priority) {
                $highest_priority = $duty_priority;
            }
        }

        $user = UserQuery::create()->findPk((int) $this->getAuth()->getData());

        $allowed_activities = $this->s('perfumerlabs.start')->getAllowedActivities($user);

        $extra_duty = DutyQuery::create()
            ->joinWith('Activity')
            ->filterByUserId((int) $this->getAuth()->getData())
            ->_or()
            ->filterByActivityId($allowed_activities, Criteria::IN)
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->filterByPickedAt(null, Criteria::ISNULL)
            ->filterByRaisedAt(new \DateTime(), Criteria::LESS_EQUAL)
            ->filterById($picked_duties->getPrimaryKeys(), Criteria::NOT_IN)
            ->useActivityQuery()
                ->filterByPriority($highest_priority, Criteria::GREATER_THAN)
                ->orderByPriority(Criteria::DESC)
            ->endUse()
            ->orderByCreatedAt()
            ->findOne();

        if ($extra_duty) {
            $extra_duty->setPickedAt(new \DateTime());
            $extra_duty->setUserId((int) $this->getAuth()->getData());

            if ($extra_duty->save()) {
                $content = $this->s('perfumerlabs.duty_formatter')->format($extra_duty, $user);

                $this->setContent($content);
            }
        }
    }

    /**
     * @return StatusView
     */
    protected function getView()
    {
        if ($this->_view === null) {
            $this->_view = $this->s('view.status');
        }

        return $this->_view;
    }
}