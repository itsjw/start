<?php

namespace Perfumerlabs\Start\Controller\Activity;

use Perfumer\Framework\Controller\TemplateController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;

class LayoutController extends TemplateController
{
    use DefaultRouterControllerHelpers;

    protected function after()
    {
        if (!$this->getView()->getTemplate()) {
            $this->getView()->setTemplate($this->getCurrent()->getResource());
        }

        parent::after();
    }
}
