<?php

namespace Perfumerlabs\Start\Controller;

use Perfumerlabs\Start\Model\ActivityQuery;
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
            ->filterByUserId($this->getUser()->getId())
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->filterByPickedAt(null, Criteria::ISNOTNULL)
            ->orderByRaisedAt()
            ->find();

        $content = [];

        foreach ($activities as $activity) {
            $Activity = $this->s('perfumerlabs.start')->getActivity($activity->getName());

            $array = [
                'id' => $activity->getId(),
                'name' => $this->getUser()->getUsername(),
                'title' => $activity->getTitle(),
                'color' => $Activity->color,
                'readonly' => $Activity->readonly,
            ];

            if ($Activity->iframe) {
                $data = $activity->getData() ? unserialize($activity->getData()) : [];
                $data['activity_id'] = $activity->getId();
                $data['activity_name'] = $Activity->name;

                $array['iframe'] = $Activity->iframe . '?' . http_build_query($data);
            }

            $content[] = $array;
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