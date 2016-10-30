<?php

namespace Start\Controller;

use Perfumer\Framework\Controller\PlainController;

class LogoutController extends PlainController
{
    public function get()
    {
        $this->getAuth()->logout();

        $this->redirect('/login');
    }
}