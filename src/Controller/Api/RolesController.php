<?php

namespace Perfumerlabs\Start\Controller\Api;

use App\Model\RoleQuery;

class RolesController extends LayoutController
{
    public function get()
    {
        $roles = RoleQuery::create()
            ->orderByName()
            ->find();

        $content = [];

        foreach ($roles as $role) {
            $content[] = [
                'id' => $role->getId(),
                'name' => $role->getName(),
            ];
        }

        $this->setContent($content);
    }
}
