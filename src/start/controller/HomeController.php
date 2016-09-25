<?php

namespace Start\Controller;

use App\Model\FragmentQuery;
use Perfumer\Framework\Controller\TemplateController;

class HomeController extends TemplateController
{
    public function get()
    {
        if (!$this->getAuth()->isLogged()) {
            $this->pageNotFoundException();
        }

        $tiles = $this->getContainer()->getResource('tiles');

        $fragments = FragmentQuery::create()
            ->joinWith('User')
            ->filterByUser($this->getUser())
            ->orderByCreatedAt()
            ->limit(50)
            ->find();

        foreach ($fragments as $fragment) {
            $fragment->setVirtualColumn('uri', $tiles[$fragment->getTile()]['uri']);
        }

        $this->getView()->addVar('fragments', $fragments);
    }
}