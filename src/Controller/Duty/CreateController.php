<?php

namespace Perfumerlabs\Start\Controller\Duty;

use App\Model\UserQuery;
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
        $duty->setUserId((int) $this->getAuth()->getData());
        $duty->setRaisedAt(new \DateTime());
        $duty->setPickedAt(new \DateTime());
        $duty->save();

        $user = UserQuery::create()->findPk((int) $this->getAuth()->getData());

        $content = $this->s('perfumerlabs.duty_formatter')->format($duty, $user);

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
