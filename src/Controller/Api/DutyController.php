<?php

namespace Perfumerlabs\Start\Controller\Api;

use Perfumerlabs\Start\Model\ActivityQuery;
use Perfumerlabs\Start\Model\Duty;
use Perfumerlabs\Start\Model\DutyQuery;
use Perfumerlabs\Start\Model\NavQuery;
use Perfumerlabs\Start\Model\VendorQuery;

class DutyController extends LayoutController
{
    public function post()
    {
        $api_key = (string) $this->f('api_key');

        $vendor = VendorQuery::create()->findOneByApiKey($api_key);

        $fields = $this->f(['description', 'iframe_url', 'validation_url', 'activity_code', 'user_id', 'raised_at', 'nav_id', 'code']);

        if ($fields['code']) {
            $similar_duty = DutyQuery::create()->findOneByCode($fields['code']);

            if ($similar_duty) {
                return;
            }
        }

        $duty = new Duty();

        if ($fields['nav_id']) {
            $nav = NavQuery::create()->findPk((int) $fields['nav_id']);

            $duty->setActivityId($nav->getActivityId());
            $duty->setIframeUrl($nav->getUrl());
            $duty->setUserId((int) $this->getAuth()->getData());
            $duty->setRaisedAt(new \DateTime());
            $duty->setPickedAt(new \DateTime());
        } else {
            $activity = ActivityQuery::create()
                ->filterByVendor($vendor)
                ->filterByCode($fields['activity_code'])
                ->findOne();

            $duty->setDescription($fields['description']);
            $duty->setIframeUrl((string) $fields['iframe_url']);
            $duty->setValidationUrl($fields['validation_url']);
            $duty->setActivity($activity);
            $duty->setUserId($fields['user_id']);
            $duty->setRaisedAt((string) $fields['raised_at']);
        }

        $duty->save();

        $this->getExternalResponse()->setStatusCode(201);

        $activity = $duty->getActivity();
        $user = $duty->getUser();

        if ($user) {
            $user_content = [
                'id' => $user->getId(),
                'username' => $user->getId()
            ];
        } else {
            $user_content = null;
        }

        $content = [
            'id' => $duty->getId(),
            'description' => $duty->getDescription(),
            'iframe_url' => $duty->getIframeUrl(),
            'validation_url' => $duty->getValidationUrl(),
            'created_at' => $duty->getCreatedAt() ? $duty->getCreatedAt('Y-m-d H:i:s') : null,
            'raised_at' => $duty->getRaisedAt() ? $duty->getRaisedAt('Y-m-d H:i:s') : null,
            'closed_at' => $duty->getClosedAt() ? $duty->getClosedAt('Y-m-d H:i:s') : null,
            'picked_at' => $duty->getPickedAt() ? $duty->getPickedAt('Y-m-d H:i:s') : null,
            'activity' => [
                'id' => $activity->getId(),
                'name' => $activity->getName(),
                'priority' => $activity->getPriority(),
                'color' => $activity->getColor(),
                'postponing' => $activity->getPostponing(),
                'closing' => $activity->getClosing(),
                'commenting' => $activity->getCommenting(),
            ],
            'user' => $user_content
        ];

        $this->setContent($content);
    }

    public function patch()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $duty = DutyQuery::create()->findPk($id);

        if (!$duty) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $action = (string) $this->f('action');

        if ($action === 'release') {
            $duty->setUserId(null);
            $duty->setPickedAt(null);
        }

        $duty->save();

        $activity = $duty->getActivity();
        $user = $duty->getUser();

        if ($user) {
            $user_content = [
                'id' => $user->getId(),
                'username' => $user->getId()
            ];
        } else {
            $user_content = null;
        }

        $content = [
            'id' => $duty->getId(),
            'description' => $duty->getDescription(),
            'iframe_url' => $duty->getIframeUrl(),
            'validation_url' => $duty->getValidationUrl(),
            'created_at' => $duty->getCreatedAt() ? $duty->getCreatedAt('Y-m-d H:i:s') : null,
            'raised_at' => $duty->getRaisedAt() ? $duty->getRaisedAt('Y-m-d H:i:s') : null,
            'closed_at' => $duty->getClosedAt() ? $duty->getClosedAt('Y-m-d H:i:s') : null,
            'picked_at' => $duty->getPickedAt() ? $duty->getPickedAt('Y-m-d H:i:s') : null,
            'activity' => [
                'id' => $activity->getId(),
                'name' => $activity->getName(),
                'priority' => $activity->getPriority(),
                'color' => $activity->getColor(),
                'postponing' => $activity->getPostponing(),
                'closing' => $activity->getClosing(),
                'commenting' => $activity->getCommenting(),
            ],
            'user' => $user_content
        ];

        $this->setContent($content);
    }

    public function delete()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $duty = DutyQuery::create()->findPk($id);

        if (!$duty) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $duty->delete();
    }
}
