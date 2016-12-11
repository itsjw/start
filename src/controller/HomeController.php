<?php

namespace Perfumerlabs\Start\Controller;

use Perfumer\Framework\Controller\TemplateController;
use Perfumerlabs\Start\Model\DutyQuery;

class HomeController extends TemplateController
{
    public function get()
    {
        if (!$this->getAuth()->isLogged()) {
            $this->redirect('/login');
        }

        $duty = DutyQuery::create()->findPk(1);
        $duty->setData(serialize(['title'=>'Text activity', 'text'=>'lorem ipsum']));
        $duty->save();
    }
}