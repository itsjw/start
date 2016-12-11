<?php

namespace Perfumerlabs\Start\Controller;

use App\Model\User;
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
            ->filterByUserId($this->getUser()->getId())
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->filterByPickedAt(null, Criteria::ISNOTNULL)
            ->find();

        $highest_priority = 0;

        foreach ($picked_duties as $duty) {
            if ($duty->getPriority() > $highest_priority) {
                $highest_priority = $duty->getPriority();
            }
        }

        $allowed_activities = $this->s('perfumerlabs.start')->getAllowedActivities($this->getUser());

        $extra_duty = DutyQuery::create()
            ->filterByUserId($this->getUser()->getId())
            ->_or()
            ->filterByActivityId($allowed_activities, Criteria::IN)
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->filterByPickedAt(null, Criteria::ISNULL)
            ->filterByRaisedAt(new \DateTime(), Criteria::LESS_EQUAL)
            ->filterByPriority($highest_priority, Criteria::GREATER_THAN)
            ->filterById($picked_duties->getPrimaryKeys(), Criteria::NOT_IN)
            ->orderByPriority(Criteria::DESC)
            ->orderByCreatedAt()
            ->findOne();

        if ($extra_duty) {
            $extra_duty->setPickedAt(new \DateTime());
            $extra_duty->setUserId($this->getUser()->getId());

            if ($extra_duty->save()) {
                $content = [
                    'id' => $extra_duty->getId(),
                    'name' => $this->getUser()->getUsername(),
                    'title' => $extra_duty->getTitle(),
                    'color' => null,
                    'readonly' => $extra_duty->getActivity()->isReadonly(),
                ];

                if ($extra_duty->getActivity()->getIframe()) {
                    $data = $extra_duty->getData() ? unserialize($extra_duty->getData()) : [];
                    $data['activity_id'] = $extra_duty->getId();
                    $data['activity_name'] = $extra_duty->getActivity()->getName();

                    $content['iframe'] = $extra_duty->getActivity()->getIframe() . '?' . http_build_query($data);
                }

                $this->setContent($content);
            }
        }
    }

    /**
     * @return User
     */
    protected function getUser()
    {
        return parent::getUser();
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