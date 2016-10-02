<?php

namespace Start\Controller;

use App\Model\FragmentQuery;
use Perfumer\Framework\Controller\TemplateController;
use Propel\Runtime\ActiveQuery\Criteria;

class HomeController extends TemplateController
{
    public function get()
    {
        if (!$this->getAuth()->isLogged()) {
            $this->pageNotFoundException();
        }

        $fragments = FragmentQuery::create()
            ->joinWith('User')
            ->filterByUser($this->getUser())
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->orderByCreatedAt(Criteria::DESC)
            ->limit(50)
            ->find();

        $this->getView()->addVar('fragments', $fragments);
    }
}