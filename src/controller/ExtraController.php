<?php

namespace Perfumerlabs\Start\Controller;

use Perfumerlabs\Start\Model\ActivityQuery;
use App\Model\User;
use Perfumer\Framework\Controller\ViewController;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;
use Propel\Runtime\ActiveQuery\Criteria;

class ExtraController extends ViewController
{
    use StatusViewControllerHelpers;

    public function get()
    {
        $picked_activities = ActivityQuery::create()
            ->filterByUser($this->getUser())
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->filterByPickedAt(null, Criteria::ISNOTNULL)
            ->find();

        $highest_priority = 0;

        foreach ($picked_activities as $activity) {
            if ($activity->getPriority() > $highest_priority) {
                $highest_priority = $activity->getPriority();
            }
        }

        $allowed_activities = $this->s('perfumerlabs.start')->getAllowedActivities($this->getUser());

        $extra_activity = ActivityQuery::create()
            ->filterByUser($this->getUser())
            ->_or()
            ->filterByName($allowed_activities, Criteria::IN)
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->filterByPickedAt(null, Criteria::ISNULL)
            ->filterByRaisedAt(new \DateTime(), Criteria::LESS_EQUAL)
            ->filterByPriority($highest_priority, Criteria::GREATER_THAN)
            ->filterById($picked_activities->getPrimaryKeys(), Criteria::NOT_IN)
            ->orderByPriority(Criteria::DESC)
            ->orderByCreatedAt()
            ->findOne();

        if ($extra_activity) {
            $extra_activity->setPickedAt(new \DateTime());
            $extra_activity->setUser($this->getUser());

            if ($extra_activity->save()) {
                $Activity = $this->s('perfumerlabs.start')->getActivity($extra_activity->getName());

                $content = [
                    'id' => $extra_activity->getId(),
                    'name' => $this->getUser()->getUsername(),
                    'title' => $extra_activity->getTitle(),
                    'color' => $Activity->color,
                    'readonly' => $Activity->readonly,
                ];

                if ($Activity->iframe) {
                    $query_string = $extra_activity->getData() ? '?' . http_build_query(unserialize($extra_activity->getData())) : '';

                    $content['iframe'] = $Activity->iframe . $query_string;
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