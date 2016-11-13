<?php

namespace Start\Api;

use Perfumer\Framework\Controller\ViewController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;
use Perfumer\Framework\View\StatusViewControllerHelpers;

class LoginController extends ViewController
{
    use DefaultRouterControllerHelpers;
    use StatusViewControllerHelpers;

    public function post()
    {
        $username = (string) $this->f('username');
        $password = (string) $this->f('password');

        $this->getAuth()->login($username, $password);

        if (!$this->getAuth()->isLogged()) {
            $this->setErrorMessage('Username or password invalid.');
        }
    }
}