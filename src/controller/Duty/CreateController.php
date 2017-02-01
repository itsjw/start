<?php

namespace Perfumerlabs\Start\Controller\Duty;

use Perfumer\Framework\Controller\ViewController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;
use Perfumerlabs\Start\Model\ActivityQuery;
use Perfumerlabs\Start\Model\Duty;

class CreateController extends ViewController
{
    use DefaultRouterControllerHelpers;
    use StatusViewControllerHelpers;

    public function post()
    {
        $activity_id = (int) $this->f('activity_id');

        $activity = ActivityQuery::create()->findPk($activity_id);

        $duty = new Duty();
        $duty->setActivity($activity);
        $duty->setUserId($this->getUser()->getId());
        $duty->setTitle($activity->getToolbar());
        $duty->setRaisedAt(new \DateTime());
        $duty->setPickedAt(new \DateTime());
        $duty->setPriority(1);
        $duty->save();

        $content = $this->s('perfumerlabs.duty_formatter')->format($duty, $this->getUser());

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
