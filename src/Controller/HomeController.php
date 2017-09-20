<?php

namespace Perfumerlabs\Start\Controller;

use App\Model\UserRoleQuery;
use Perfumer\Framework\Controller\TemplateController;
use Perfumerlabs\Start\Model\NavQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class HomeController extends TemplateController
{
    public function get()
    {
        if (!$this->getAuth()->isAuthenticated()) {
            $this->redirect('/login');
        }

        $user_id = (int) $this->getAuth()->getData();

        $roles = UserRoleQuery::create()
            ->filterByUserId($user_id)
            ->select('role_id')
            ->find()
            ->getData();

        $navs = NavQuery::create()
            ->useNavAccessQuery()
                ->filterByUserId($user_id)
                ->_or()
                ->filterByRoleId($roles, Criteria::IN)
            ->endUse()
            ->orderByPriority(Criteria::DESC)
            ->find();

        $this->getView()->addVars([
            'navs' => $navs,
            'static_version' => $this->getStaticVersion()
        ]);
    }

    private function getStaticVersion()
    {
        if (ENV === 'dev') {
            $static_version = null;
        } else {
            $cache = $this->getContainer()->get('cache.file')->getItem('static.version');

            $static_version = $cache->get();

            if ($cache->isMiss()) {
                $cache->lock();

                $static_version = time();

                $cache->set($static_version, 30 * 86400);
            }
        }

        return $static_version;
    }
}
