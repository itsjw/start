<?php

namespace Perfumerlabs\Start\Controller\Duty;

use Perfumer\Framework\Controller\PlainController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;
use Perfumerlabs\Start\Model\DutyQuery;

class PostponeController extends PlainController
{
    use DefaultRouterControllerHelpers;
    use StatusViewControllerHelpers;

    public function post()
    {
        $id = (int) $this->i();
        $period = (string) $this->f('period');

        $date = (new \DateTime())->modify($period);

        $duty = DutyQuery::create()->findPk($id);

        if ($duty) {
            $this->s('perfumerlabs.duty')->postpone($duty, $date);
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