<?php

namespace Perfumerlabs\Start\Controller\Api;

use Perfumerlabs\Start\Model\Duty;
use Perfumerlabs\Start\Model\DutyQuery;
use Perfumerlabs\Start\Model\NavQuery;

class DutyController extends LayoutController
{
    public function post()
    {
        $fields = $this->f(['description', 'iframe_url', 'validation_url', 'activity_id', 'user_id', 'raised_at', 'nav_id']);

        $duty = new Duty();

        if ($fields['nav_id']) {
            $nav = NavQuery::create()->findPk((int) $fields['nav_id']);

            $duty->setActivityId($nav->getActivityId());
            $duty->setIframeUrl($nav->getUrl());
            $duty->setUserId((int) $this->getAuth()->getData());
            $duty->setRaisedAt(new \DateTime());
            $duty->setPickedAt(new \DateTime());
        } else {
            $duty->setDescription($fields['description']);
            $duty->setIframeUrl((string) $fields['iframe_url']);
            $duty->setValidationUrl($fields['validation_url']);
            $duty->setActivityId((int) $fields['activity_id']);
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
                'postponing' => $activity->getPostponable(),
                'closing' => $activity->getReadonly(),
                'commenting' => $activity->getWritable(),
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
                'postponing' => $activity->getPostponable(),
                'closing' => $activity->getReadonly(),
                'commenting' => $activity->getWritable(),
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
