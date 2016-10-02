<?php

namespace Start\Controller;

use Perfumer\Framework\Controller\TemplateController;

class HomeController extends TemplateController
{
    public function get()
    {
        if (!$this->getAuth()->isLogged()) {
            $this->pageNotFoundException();
        }
    }
}