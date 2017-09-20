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

        $vendor = $activity->getVendor();

        $this->setContent([
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
        ]);
    }

    public function post()
    {
        $fields = $this->f(['name', 'vendor_id', 'priority', 'color', 'postponing', 'closing', 'commenting']);

        $activity = new Activity();
        $activity->setName((string) $fields['name']);
        $activity->setVendorId((int) $fields['vendor_id']);
        $activity->setPriority((int) $fields['priority']);
        $activity->setColor((string) $fields['color']);
        $activity->setPostponable((bool) $fields['postponing']);
        $activity->setReadonly((bool) $fields['closing']);
        $activity->setWritable((bool) $fields['commenting']);
        $activity->save();

        $this->getExternalResponse()->setStatusCode(201);

        $vendor = $activity->getVendor();

        $this->setContent([
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
        ]);
    }

    public function put()
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

        $fields = $this->f(['name', 'vendor_id', 'priority', 'color', 'postponing', 'closing', 'commenting']);

        $activity->setName((string) $fields['name']);
        $activity->setVendorId((int) $fields['vendor_id']);
        $activity->setPriority((int) $fields['priority']);
        $activity->setColor((string) $fields['color']);
        $activity->setPostponable((bool) $fields['postponing']);
        $activity->setReadonly((bool) $fields['closing']);
        $activity->setWritable((bool) $fields['commenting']);
        $activity->save();

        $vendor = $activity->getVendor();

        $this->setContent([
            'id' => $activity->getId(),
            'name' => $activity->getName(),
            'iframe' => $activity->getIframe(),
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
