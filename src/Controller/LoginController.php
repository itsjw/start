<?php

namespace Perfumerlabs\Start\Controller;

use App\Model\UserQuery;
use Perfumer\Framework\Controller\TemplateController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;

class LoginController extends TemplateController
{
    use DefaultRouterControllerHelpers;

    public function get()
    {
        if ($this->getAuth()->isAuthenticated()) {
            $this->redirect('/home');
        }

        $username = (string) $this->f('username');
        $password = (string) $this->f('password');

        if ($username && $password) {
            $user = UserQuery::create()->findOneByUsername($username);

            if (!$user || !password_verify($password, $user->getPassword())) {
                $this->redirect('/login');
            }

            $this->getAuth()->startSession((string) $user->getId());

            $this->redirect('/home');
        }
    }
}
