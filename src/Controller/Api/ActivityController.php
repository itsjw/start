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
            'postponing' => $activity->getPostponing(),
            'closing' => $activity->getClosing(),
            'commenting' => $activity->getCommenting(),
            'vendor_id' => $activity->getVendorId(),
            'vendor' => [
                'id' => $vendor->getId(),
                'name' => $vendor->getName(),
                'hostname' => $vendor->getHostname(),
            ]
        ]);
    }

    public function post()
    {
        $fields = $this->f(['name', 'vendor_id', 'priority', 'color', 'postponing', 'closing', 'commenting', 'iframe_url']);

        $activity = new Activity();
        $activity->setName((string) $fields['name']);
        $activity->setVendorId((int) $fields['vendor_id']);
        $activity->setPriority((int) $fields['priority']);
        $activity->setColor((string) $fields['color']);
        $activity->setPostponing((bool) $fields['postponing']);
        $activity->setClosing((bool) $fields['closing']);
        $activity->setCommenting((bool) $fields['commenting']);
        $activity->setIframeUrl($fields['iframe_url']);
        $activity->save();

        $this->getExternalResponse()->setStatusCode(201);

        $vendor = $activity->getVendor();

        $this->setContent([
            'id' => $activity->getId(),
            'name' => $activity->getName(),
            'priority' => $activity->getPriority(),
            'color' => $activity->getColor(),
            'postponing' => $activity->getPostponing(),
            'closing' => $activity->getClosing(),
            'commenting' => $activity->getCommenting(),
            'vendor_id' => $activity->getVendorId(),
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

        $fields = $this->f(['name', 'vendor_id', 'priority', 'color', 'postponing', 'closing', 'commenting', 'iframe_url']);

        $activity->setName((string) $fields['name']);
        $activity->setVendorId((int) $fields['vendor_id']);
        $activity->setPriority((int) $fields['priority']);
        $activity->setColor((string) $fields['color']);
        $activity->setPostponing((bool) $fields['postponing']);
        $activity->setClosing((bool) $fields['closing']);
        $activity->setCommenting((bool) $fields['commenting']);
        $activity->setIframeUrl($fields['iframe_url']);
        $activity->save();

        $vendor = $activity->getVendor();

        $this->setContent([
            'id' => $activity->getId(),
            'name' => $activity->getName(),
            'priority' => $activity->getPriority(),
            'color' => $activity->getColor(),
            'postponing' => $activity->getPostponing(),
            'closing' => $activity->getClosing(),
            'commenting' => $activity->getCommenting(),
            'vendor_id' => $activity->getVendorId(),
            'vendor' => [
                'id' => $vendor->getId(),
                'name' => $vendor->getName(),
                'hostname' => $vendor->getHostname(),
            ]
        ]);
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
