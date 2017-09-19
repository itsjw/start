<?php

namespace Perfumerlabs\Start\Controller\Api;

use Perfumerlabs\Start\Model\DutyQuery;

class DutyController extends LayoutController
{
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
            'raised_at' => $duty->getRaisedAt() ? $duty->getRaisedAt('Y-m-d H:i:s') : null,
            'closed_at' => $duty->getCreatedAt() ? $duty->getCreatedAt('Y-m-d H:i:s') : null,
            'picked_at' => $duty->getPickedAt() ? $duty->getPickedAt('Y-m-d H:i:s') : null,
            'activity' => [
                'id' => $activity->getId(),
                'name' => $activity->getName(),
                'iframe' => $activity->getIframe(),
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
