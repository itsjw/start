<?php

namespace Perfumerlabs\Start\Controller\Api;

use App\Model\Role;
use App\Model\RoleQuery;
use Perfumerlabs\Start\Model\ActivityAccess;
use Perfumerlabs\Start\Model\ActivityAccessQuery;
use Perfumerlabs\Start\Model\NavAccess;
use Perfumerlabs\Start\Model\NavAccessQuery;
use Propel\Runtime\ActiveQuery\Criteria;

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

        $activities = ActivityAccessQuery::create()
            ->filterByRole($role)
            ->filterByActivityId(null, Criteria::ISNOTNULL)
            ->select('activity_id')
            ->find()
            ->getData();

        $navs = NavAccessQuery::create()
            ->filterByRole($role)
            ->filterByNavId(null, Criteria::ISNOTNULL)
            ->select('nav_id')
            ->find()
            ->getData();

        $this->setContent([
            'id' => $role->getId(),
            'name' => $role->getName(),
            'activities' => $activities,
            'navs' => $navs,
        ]);
    }

    public function post()
    {
        $fields = $this->f(['name']);
        $activities = (array) $this->f('activities');
        $navs = (array) $this->f('navs');

        $role = new Role();
        $role->setName((string) $fields['name']);
        $role->save();

        foreach ($activities as $activity) {
            $activity_access = new ActivityAccess();
            $activity_access->setActivityId($activity);
            $activity_access->setRole($role);
            $activity_access->save();
        }

        foreach ($navs as $nav) {
            $nav_access = new NavAccess();
            $nav_access->setNavId($nav);
            $nav_access->setRole($role);
            $nav_access->save();
        }

        $this->getExternalResponse()->setStatusCode(201);

        $this->setContent([
            'id' => $role->getId(),
            'name' => $role->getName(),
            'activities' => $activities,
            'navs' => $navs,
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
        $activities = (array) $this->f('activities');
        $navs = (array) $this->f('navs');

        $role->setName((string) $fields['name']);
        $role->save();

        ActivityAccessQuery::create()
            ->filterByRole($role)
            ->filterByActivityId($activities, Criteria::NOT_IN)
            ->delete();

        foreach ($activities as $activity) {
            $activity_access = ActivityAccessQuery::create()
                ->filterByActivityId($activity)
                ->filterByRole($role)
                ->findOneOrCreate();

            $activity_access->save();
        }

        NavAccessQuery::create()
            ->filterByRole($role)
            ->filterByNavId($navs, Criteria::NOT_IN)
            ->delete();

        foreach ($navs as $nav) {
            $nav_access = NavAccessQuery::create()
                ->filterByNavId($nav)
                ->filterByRole($role)
                ->findOneOrCreate();

            $nav_access->save();
        }

        $this->setContent([
            'id' => $role->getId(),
            'name' => $role->getName(),
            'activities' => $activities,
            'navs' => $navs,
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
