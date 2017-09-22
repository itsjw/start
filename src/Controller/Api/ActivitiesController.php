<?php

namespace Perfumerlabs\Start\Controller\Api;

use Perfumerlabs\Start\Model\ActivityQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class ActivitiesController extends LayoutController
{
    public function get()
    {
        $activities = ActivityQuery::create()
            ->joinWithVendor(Criteria::LEFT_JOIN)
            ->orderByName()
            ->find();

        $content = [];

        foreach ($activities as $activity) {

            $item = [
                'id' => $activity->getId(),
                'name' => $activity->getName(),
                'priority' => $activity->getPriority(),
                'color' => $activity->getColor(),
                'postponing' => $activity->getPostponing(),
                'closing' => $activity->getClosing(),
                'commenting' => $activity->getCommenting(),
                'vendor_id' => $activity->getVendorId(),
                'vendor' => null
            ];

            if ($activity->getVendorId()) {
                $vendor = $activity->getVendor();

                $item['vendor'] = [
                    'id' => $vendor->getId(),
                    'name' => $vendor->getName(),
                    'hostname' => $vendor->getHostname(),
                ];
            }

            $content[] = $item;
        }

        $this->setContent($content);
    }
}
