<?php

namespace Perfumerlabs\Start\Controller;

use Perfumer\Framework\Controller\TemplateController;
use Perfumerlabs\Start\Model\ActivityQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class HomeController extends TemplateController
{
    public function get()
    {
        if (!$this->getAuth()->isAuthenticated()) {
            $this->redirect('/login');
        }

        $toolbars = ActivityQuery::create()
            ->filterByToolbar(null, Criteria::ISNOTNULL)
            ->orderByToolbar()
            ->find();

        $this->getView()->addVars([
            'toolbars' => $toolbars,
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
