<?php

namespace Perfumerlabs\Start\Controller;

use Perfumer\Framework\Controller\TemplateController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;

class LoginController extends TemplateController
{
    use DefaultRouterControllerHelpers;

    public function get()
    {
        if ($this->getAuth()->isLogged()) {
            $this->redirect('/home');
        }

        $username = (string) $this->f('username');
        $password = (string) $this->f('password');

        if ($username && $password) {
            $this->getAuth()->login($username, $password);

            if ($this->getAuth()->isLogged()) {
                $this->redirect('/home');
            } else {
                $this->forward('login', 'get');
            }
        }
    }
}