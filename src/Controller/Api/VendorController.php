<?php

namespace Perfumerlabs\Start\Controller\Api;

use Perfumerlabs\Start\Model\Vendor;
use Perfumerlabs\Start\Model\VendorQuery;

class VendorController extends LayoutController
{
    public function get()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $vendor = VendorQuery::create()->findPk($id);

        if (!$vendor) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $this->setContent([
            'id' => $vendor->getId(),
            'name' => $vendor->getName(),
            'hostname' => $vendor->getHostname(),
        ]);
    }

    public function post()
    {
        $fields = $this->f(['name', 'hostname']);

        $vendor = new Vendor();
        $vendor->setName((string) $fields['name']);
        $vendor->setHostname((string) $fields['hostname']);
        $vendor->save();

        $this->getExternalResponse()->setStatusCode(201);

        $this->setContent([
            'id' => $vendor->getId(),
            'name' => $vendor->getName(),
            'hostname' => $vendor->getHostname(),
        ]);
    }

    public function put()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $vendor = VendorQuery::create()->findPk($id);

        if (!$vendor) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $fields = $this->f(['name', 'hostname']);

        $vendor->setName((string) $fields['name']);
        $vendor->setHostname((string) $fields['hostname']);
        $vendor->save();

        $this->setContent([
            'id' => $vendor->getId(),
            'name' => $vendor->getName(),
            'hostname' => $vendor->getHostname(),
        ]);
    }

    public function patch()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $vendor = VendorQuery::create()->findPk($id);

        if (!$vendor) {
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

        $vendor = VendorQuery::create()->findPk($id);

        if (!$vendor) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $vendor->delete();
    }
}
