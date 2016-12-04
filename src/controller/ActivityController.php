<?php

namespace Perfumerlabs\Start\Controller;

use Perfumerlabs\Start\Model\ActivityQuery;
use Perfumer\Framework\Controller\PlainController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;

class ActivityController extends PlainController
{
    use DefaultRouterControllerHelpers;

    public function get()
    {
        $id = (int) $this->i();

        $activity = ActivityQuery::create()->findPk($id);

        if (!$activity) {
            $this->pageNotFoundException();
        }

        $reference = $this->s('perfumerlabs.start')->getActivity($activity->getCode());

        if (!$reference->amd) {
            $this->pageNotFoundException();
        }

        $amd = $reference->amd;
        $amd = explode('.', $amd);

        $data = $activity->getData() === null ? [] : unserialize($activity->getData());
        $data['created_at'] = $activity->getCreatedAt();
        $data['id'] = $id;

        $this->getProxy()->forward($amd[0], $amd[1], $amd[2], $data);
    }

    public function post()
    {
        $id = (int) $this->i();

        $activity = ActivityQuery::create()->findPk($id);

        if ($activity) {
            $this->s('perfumerlabs.activity')->close($activity);
        }
    }
}