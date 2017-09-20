<?php

namespace Perfumerlabs\Start\Controller\Api;

use Perfumerlabs\Start\Model\NavQuery;

class NavsController extends LayoutController
{
    public function get()
    {
        $navs = NavQuery::create()
            ->orderByName()
            ->find();

        $content = [];

        foreach ($navs as $nav) {
            $content[] = [
                'id' => $nav->getId(),
                'name' => $nav->getName(),
                'activity_id' => $nav->getActivityId(),
                'url' => $nav->getUrl(),
                'priority' => $nav->getPriority()
            ];
        }

        $this->setContent($content);
    }
}
