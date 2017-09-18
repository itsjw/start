<?php

namespace Perfumerlabs\Start\Controller\Api;

use Perfumerlabs\Start\Model\ActivityQuery;

class ActivitiesController extends LayoutController
{
    public function get()
    {
        $activities = ActivityQuery::create()
            ->orderByName()
            ->find();

        $content = [];

        foreach ($activities as $activity) {
            $content[] = [
                'id' => $activity->getId(),
                'name' => $activity->getName(),
            ];
        }

        $this->setContent($content);
    }
}
