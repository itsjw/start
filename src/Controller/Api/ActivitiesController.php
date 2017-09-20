<?php

namespace Perfumerlabs\Start\Controller\Api;

use Perfumerlabs\Start\Model\ActivityQuery;

class ActivitiesController extends LayoutController
{
    public function get()
    {
        $activities = ActivityQuery::create()
            ->joinWithVendor()
            ->orderByName()
            ->find();

        $content = [];

        foreach ($activities as $activity) {
            $vendor = $activity->getVendor();

            $content[] = [
                'id' => $activity->getId(),
                'name' => $activity->getName(),
                'priority' => $activity->getPriority(),
                'color' => $activity->getColor(),
                'postponing' => $activity->getPostponable(),
                'closing' => $activity->getReadonly(),
                'commenting' => $activity->getWritable(),
                'vendor' => [
                    'id' => $vendor->getId(),
                    'name' => $vendor->getName(),
                    'hostname' => $vendor->getHostname(),
                ]
            ];
        }

        $this->setContent($content);
    }
}
