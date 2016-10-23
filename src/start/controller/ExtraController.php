<?php

namespace Start\Controller;

use App\Model\ActivityQuery;
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

        $extra_activity = ActivityQuery::create()
            ->filterByUser($this->getUser())
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->filterByRaisedAt(new \DateTime(), Criteria::LESS_EQUAL)
            ->filterByPriority($highest_priority, Criteria::GREATER_THAN)
            ->filterById($picked_activities->getPrimaryKeys(), Criteria::NOT_IN)
            ->orderByCreatedAt()
            ->findOne();

        if ($extra_activity) {
            $extra_activity->setPickedAt(new \DateTime());

            if ($extra_activity->save()) {
                $content = [
                    'id' => $extra_activity->getId(),
                    'name' => $extra_activity->getUser()->getUsername(),
                    'title' => $extra_activity->getTitle()
                ];

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