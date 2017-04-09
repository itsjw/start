<?php

namespace Perfumerlabs\Start\Controller;

use App\Model\UserQuery;
use Perfumer\Framework\Controller\ViewController;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;
use Perfumerlabs\Start\Model\Duty;
use Perfumerlabs\Start\Model\DutyQuery;
use Perfumerlabs\Start\Model\RelatedTagQuery;
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
            /** @var Duty $duty */
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
            $content = [];

            $extra_duty->setPickedAt(new \DateTime());
            $extra_duty->setUserId((int) $this->getAuth()->getData());

            if ($extra_duty->save()) {
                $content[] = $this->s('perfumerlabs.duty_formatter')->format($extra_duty, $user);
            }

            $related_tag_ids = RelatedTagQuery::create()
                ->filterByDutyId($extra_duty->getId())
                ->select('tag_id')
                ->find()
                ->getData();

            if ($related_tag_ids) {
                $related_duties = DutyQuery::create()
                    ->joinWith('Activity')
                    ->filterByUserId((int) $this->getAuth()->getData())
                    ->_or()
                    ->filterByActivityId($allowed_activities, Criteria::IN)
                    ->filterByClosedAt(null, Criteria::ISNULL)
                    ->filterByPickedAt(null, Criteria::ISNULL)
                    ->filterByRaisedAt(new \DateTime(), Criteria::LESS_EQUAL)
                    ->filterById($picked_duties->getPrimaryKeys(), Criteria::NOT_IN)
                    ->useRelatedTagQuery()
                        ->filterByTagId($related_tag_ids, Criteria::IN)
                    ->endUse()
                    ->useActivityQuery()
                        ->orderByPriority(Criteria::DESC)
                    ->endUse()
                    ->orderByCreatedAt()
                    ->find();

                foreach ($related_duties as $related_duty) {
                    $related_duty->setPickedAt(new \DateTime());
                    $related_duty->setUserId((int) $this->getAuth()->getData());

                    if ($related_duty->save()) {
                        $content[] = $this->s('perfumerlabs.duty_formatter')->format($related_duty, $user);
                    }
                }
            }

            $this->setContent($content);
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