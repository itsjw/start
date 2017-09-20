<?php

namespace Perfumerlabs\Start\Controller\Api;

use App\Model\RoleQuery;
use App\Model\User;
use App\Model\UserQuery;
use App\Model\UserRole;
use App\Model\UserRoleQuery;
use Perfumerlabs\Start\Model\ActivityAccess;
use Perfumerlabs\Start\Model\ActivityAccessQuery;
use Perfumerlabs\Start\Model\NavAccess;
use Perfumerlabs\Start\Model\NavAccessQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class UserController extends LayoutController
{
    public function get()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $user = UserQuery::create()->findPk($id);

        if (!$user) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $roles = UserRoleQuery::create()
            ->filterByUser($user)
            ->select('role_id')
            ->find()
            ->getData();

        $activities = ActivityAccessQuery::create()
            ->filterByUser($user)
            ->filterByActivityId(null, Criteria::ISNOTNULL)
            ->select('activity_id')
            ->find()
            ->getData();

        $navs = NavAccessQuery::create()
            ->filterByUser($user)
            ->filterByNavId(null, Criteria::ISNOTNULL)
            ->select('nav_id')
            ->find()
            ->getData();

        $this->setContent([
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'activities' => $activities,
            'navs' => $navs,
            'roles' => $roles,
        ]);
    }

    public function post()
    {
        $fields = $this->f(['username', 'password', 'first_name', 'last_name']);
        $activities = (array) $this->f('activities');
        $navs = (array) $this->f('navs');
        $roles = (array) $this->f('roles');

        $user = new User();
        $user->setUsername((string) $fields['username']);
        $user->setPassword(password_hash($fields['password'], PASSWORD_DEFAULT));
        $user->setFirstName($fields['first_name']);
        $user->setLastName($fields['last_name']);
        $user->save();

        foreach ($activities as $activity) {
            $activity_access = new ActivityAccess();
            $activity_access->setActivityId($activity);
            $activity_access->setUser($user);
            $activity_access->save();
        }

        foreach ($navs as $nav) {
            $nav_access = new NavAccess();
            $nav_access->setNavId($nav);
            $nav_access->setUser($user);
            $nav_access->save();
        }

        foreach ($roles as $role) {
            $user_role = new UserRole();
            $user_role->setRoleId($role);
            $user_role->setUser($user);
            $user_role->save();
        }

        $this->getExternalResponse()->setStatusCode(201);

        $this->setContent([
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'activities' => $activities,
            'navs' => $navs,
            'roles' => $roles,
        ]);
    }

    public function put()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $user = UserQuery::create()->findPk($id);

        if (!$user) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $fields = $this->f(['username', 'password', 'first_name', 'last_name']);
        $activities = (array) $this->f('activities');
        $navs = (array) $this->f('navs');
        $roles = (array) $this->f('roles');

        $user->setUsername((string) $fields['username']);

        if ($fields['password']) {
            $user->setPassword(password_hash($fields['password'], PASSWORD_DEFAULT));
        }

        $user->setFirstName($fields['first_name']);
        $user->setLastName($fields['last_name']);
        $user->save();

        UserRoleQuery::create()
            ->filterByUser($user)
            ->filterByRoleId($roles, Criteria::NOT_IN)
            ->delete();

        foreach ($roles as $role) {
            $user_role = UserRoleQuery::create()
                ->filterByRoleId($role)
                ->filterByUser($user)
                ->findOneOrCreate();

            $user_role->save();
        }

        ActivityAccessQuery::create()
            ->filterByUser($user)
            ->filterByActivityId($activities, Criteria::NOT_IN)
            ->delete();

        foreach ($activities as $activity) {
            $activity_access = ActivityAccessQuery::create()
                ->filterByActivityId($activity)
                ->filterByUser($user)
                ->findOneOrCreate();

            $activity_access->save();
        }

        NavAccessQuery::create()
            ->filterByUser($user)
            ->filterByNavId($navs, Criteria::NOT_IN)
            ->delete();

        foreach ($navs as $nav) {
            $nav_access = NavAccessQuery::create()
                ->filterByNavId($nav)
                ->filterByUser($user)
                ->findOneOrCreate();

            $nav_access->save();
        }

        $this->setContent([
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'activities' => $activities,
            'navs' => $navs,
            'roles' => $roles,
        ]);
    }

    public function delete()
    {
        $id = (int) $this->i();

        if (!$id) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $user = UserQuery::create()->findPk($id);

        if (!$user) {
            $this->getExternalResponse()->setStatusCode(404);
            $this->setStatusAndExit(false);
        }

        $user->delete();
    }
}
