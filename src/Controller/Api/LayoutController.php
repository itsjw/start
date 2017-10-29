<?php

namespace Perfumerlabs\Start\Controller\Api;

use Perfumer\Framework\Controller\ViewController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;

class LayoutController extends ViewController
{
    use DefaultRouterControllerHelpers;
    use StatusViewControllerHelpers;

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
