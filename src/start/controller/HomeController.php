<?php

namespace Start\Controller;

use App\Model\FragmentQuery;
use Perfumer\Framework\Controller\TemplateController;

class HomeController extends TemplateController
{
    public function get()
    {
        $fragments = FragmentQuery::create()
            ->joinWith('User')
            ->orderByCreatedAt()
            ->limit(50)
            ->find();

        $this->getView()->addVar('fragments', $fragments);
    }
}