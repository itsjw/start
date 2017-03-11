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
        $datetime = (string) $this->f('datetime');
        $date = null;

        if ($period) {
            $date = (new \DateTime())->modify($period);
        }

        if ($datetime) {
            $date = new \DateTime($datetime);
        }

        $duty = DutyQuery::create()->findPk($id);

        if ($duty && $date) {
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