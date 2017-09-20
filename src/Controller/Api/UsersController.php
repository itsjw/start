<?php

namespace Perfumerlabs\Start\Controller\Api;

use App\Model\UserQuery;
use App\Model\UserRoleQuery;
use Perfumerlabs\Start\Model\ActivityAccessQuery;
use Perfumerlabs\Start\Model\NavAccessQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class UsersController extends LayoutController
{
    public function get()
    {
        $users = UserQuery::create()
            ->orderByUsername()
            ->find();

        $content = [];

        foreach ($users as $user) {
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

            $content[] = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'activities' => $activities,
                'navs' => $navs,
                'roles' => $roles,
            ];
        }

        $this->setContent($content);
    }
}
