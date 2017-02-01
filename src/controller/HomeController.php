<?php

namespace Perfumerlabs\Start\Controller;

use Perfumer\Framework\Controller\TemplateController;
use Perfumerlabs\Start\Model\ActivityQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class HomeController extends TemplateController
{
    public function get()
    {
        if (!$this->getAuth()->isLogged()) {
            $this->redirect('/login');
        }

        $toolbars = ActivityQuery::create()
            ->filterByToolbar(null, Criteria::ISNOTNULL)
            ->orderByToolbar()
            ->find();

        $this->getView()->addVar('toolbars', $toolbars);
    }
}
