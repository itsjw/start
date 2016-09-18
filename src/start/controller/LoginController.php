<?php

namespace Start\Controller;

use Perfumer\Framework\Controller\PlainController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;

class LoginController extends PlainController
{
    use DefaultRouterControllerHelpers;

    public function get()
    {
        $username = (string) $this->f('username');
        $password = (string) $this->f('password');

        $this->getAuth()->login($username, $password);

        if ($this->getAuth()->isLogged()) {
            $this->redirect('/home');
        } else {
            $this->pageNotFoundException();
        }
    }
}