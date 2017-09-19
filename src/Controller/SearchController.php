<?php

namespace Perfumerlabs\Start\Controller;

use App\Model\UserQuery;
use Perfumer\Framework\Controller\ViewController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;
use Perfumerlabs\Start\Model\DutyQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class SearchController extends ViewController
{
    use DefaultRouterControllerHelpers;
    use StatusViewControllerHelpers;

    public function get()
    {
        $content = [];

        $query = (string) $this->f('query');

        if ($query) {
            $duties = DutyQuery::create()
                ->joinWith('Activity')
                ->filterByDescription('%' . $query . '%', Criteria::ILIKE)
                ->filterByClosedAt(null, Criteria::ISNULL)
                ->filterByPickedAt(null, Criteria::ISNULL)
                ->orderByRaisedAt()
                ->find();

            $user = UserQuery::create()->findPk((int) $this->getAuth()->getData());

            foreach ($duties as $duty) {
                $content[] = $this->s('perfumerlabs.duty_formatter')->format($duty, $user);
            }
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
