<?php

namespace Perfumerlabs\Start\Controller\Duty;

use Perfumer\Framework\Controller\PlainController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;
use Perfumerlabs\Start\Model\DutyQuery;

class CommentController extends PlainController
{
    use DefaultRouterControllerHelpers;
    use StatusViewControllerHelpers;

    public function post()
    {
        $id = (int) $this->i();
        $comment = (string) $this->f('comment');

        $duty = DutyQuery::create()->findPk($id);

        if ($duty) {
            $this->s('perfumerlabs.duty')->comment($duty, $comment);
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