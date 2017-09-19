<?php

namespace Perfumerlabs\Start\Controller\Api;

use App\Model\Role;
use App\Model\RoleQuery;

class RoleController extends LayoutController
{
    public function get()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $role = RoleQuery::create()->findPk($id);

        if (!$role) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $this->setContent([
            'id' => $role->getId(),
            'name' => $role->getName(),
        ]);
    }

    public function post()
    {
        $fields = $this->f(['name']);

        $role = new Role();
        $role->setName((string) $fields['name']);
        $role->save();

        $this->getExternalResponse()->setStatusCode(201);

        $this->setContent([
            'id' => $role->getId(),
            'name' => $role->getName(),
        ]);
    }

    public function put()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $role = RoleQuery::create()->findPk($id);

        if (!$role) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $fields = $this->f(['name']);

        $role->setName((string) $fields['name']);
        $role->save();

        $this->setContent([
            'id' => $role->getId(),
            'name' => $role->getName(),
        ]);
    }

    public function delete()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $role = RoleQuery::create()->findPk($id);

        if (!$role) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $role->delete();
    }
}
