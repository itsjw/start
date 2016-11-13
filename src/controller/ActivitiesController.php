<?php

namespace Start\Controller;

use App\Model\ActivityQuery;
use Perfumer\Framework\Controller\ViewController;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;
use Propel\Runtime\ActiveQuery\Criteria;

class ActivitiesController extends ViewController
{
    use StatusViewControllerHelpers;

    public function get()
    {
        $activities = ActivityQuery::create()
            ->filterByUser($this->getUser())
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->filterByPickedAt(null, Criteria::ISNOTNULL)
            ->orderByRaisedAt()
            ->find();

        $content = [];

        foreach ($activities as $activity) {
            $content[] = [
                'id' => $activity->getId(),
                'name' => $this->getUser()->getUsername(),
                'title' => $activity->getTitle(),
                'color' => $this->s('start')->getActivity($activity->getCode())->color,
                'readonly' => $this->s('start')->getActivity($activity->getCode())->readonly,
            ];
        }

        $this->setContent($content);
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