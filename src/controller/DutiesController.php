<?php

namespace Perfumerlabs\Start\Controller;

use Perfumer\Framework\Controller\ViewController;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;
use Perfumerlabs\Start\Model\DutyQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class DutiesController extends ViewController
{
    use StatusViewControllerHelpers;

    public function get()
    {
        $duties = DutyQuery::create()
            ->joinWith('Activity')
            ->filterByUserId($this->getUser()->getId())
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->filterByPickedAt(null, Criteria::ISNOTNULL)
            ->orderByRaisedAt()
            ->find();

        $content = [];

        foreach ($duties as $duty) {
            $content[] = $this->s('perfumerlabs.duty_formatter')->format($duty, $this->getUser());
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