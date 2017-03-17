<?php

namespace Perfumerlabs\Start\Controller\Duty;

use App\Model\UserQuery;
use Perfumer\Framework\Controller\PlainController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;
use Perfumerlabs\Start\Model\DutyQuery;

class PickController extends PlainController
{
    use DefaultRouterControllerHelpers;
    use StatusViewControllerHelpers;

    public function post()
    {
        $id = (int) $this->i();

        $duty = DutyQuery::create()->findPk($id);

        $user = UserQuery::create()->findPk((int) $this->getAuth()->getData());

        if ($duty) {
            $this->s('perfumerlabs.duty')->pick($user, $duty);
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