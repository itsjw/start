<?php

namespace Perfumerlabs\Start\Controller\Api;

use Perfumerlabs\Start\Model\Activity;
use Perfumerlabs\Start\Model\ActivityQuery;

class ActivityController extends LayoutController
{
    public function get()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $activity = ActivityQuery::create()->findPk($id);

        if (!$activity) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $this->setContent([
            'id' => $activity->getId(),
            'name' => $activity->getName(),
            'iframe' => $activity->getIframe(),
            'priority' => $activity->getPriority(),
            'color' => $activity->getColor(),
            'postponing' => $activity->getPostponable(),
            'closing' => $activity->getReadonly(),
            'commenting' => $activity->getWritable(),
        ]);
    }

    public function post()
    {
        $fields = $this->f(['name', 'iframe', 'priority', 'color', 'postponing', 'closing', 'commenting']);

        $activity = new Activity();
        $activity->setName((string) $fields['name']);
        $activity->setIframe((string) $fields['iframe']);
        $activity->setPriority((int) $fields['priority']);
        $activity->setColor((string) $fields['color']);
        $activity->setPostponable((bool) $fields['postponing']);
        $activity->setReadonly((bool) $fields['closing']);
        $activity->setWritable((bool) $fields['commenting']);
        $activity->save();

        $this->getExternalResponse()->setStatusCode(201);

        $this->setContent([
            'id' => $activity->getId(),
            'name' => $activity->getName(),
            'iframe' => $activity->getIframe(),
            'priority' => $activity->getPriority(),
            'color' => $activity->getColor(),
            'postponing' => $activity->getPostponable(),
            'closing' => $activity->getReadonly(),
            'commenting' => $activity->getWritable(),
        ]);
    }

    public function put()
    {
        $fields = $this->f(['id', 'name', 'iframe', 'priority', 'color', 'postponing', 'closing', 'commenting']);

        if (!$fields['id']) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $activity = new Activity();
        $activity->setId((int) $fields['id']);
        $activity->setName((string) $fields['name']);
        $activity->setIframe((string) $fields['iframe']);
        $activity->setPriority((int) $fields['priority']);
        $activity->setColor((string) $fields['color']);
        $activity->setPostponable((bool) $fields['postponing']);
        $activity->setReadonly((bool) $fields['closing']);
        $activity->setWritable((bool) $fields['commenting']);
        $activity->save();

        $this->setContent([
            'id' => $activity->getId(),
            'name' => $activity->getName(),
            'iframe' => $activity->getIframe(),
            'priority' => $activity->getPriority(),
            'color' => $activity->getColor(),
            'postponing' => $activity->getPostponable(),
            'closing' => $activity->getReadonly(),
            'commenting' => $activity->getWritable(),
        ]);
    }

    public function patch()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $activity = ActivityQuery::create()->findPk($id);

        if (!$activity) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }
    }

    public function delete()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $activity = ActivityQuery::create()->findPk($id);

        if (!$activity) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $activity->delete();
    }
}
