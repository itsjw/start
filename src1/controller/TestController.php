<?php

namespace Perfumerlabs\Start\Controller;

use Perfumer\Framework\Controller\TemplateController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;

class TestController extends TemplateController
{
    use DefaultRouterControllerHelpers;

    public function get()
    {
        $this->getView()->addVar('_id', $this->f('_id'));
    }
}
