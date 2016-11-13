<?php

namespace Start\Api;

use App\Model\ActivityQuery;
use Perfumer\Framework\Controller\PlainController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;

class ActivityController extends PlainController
{
    use DefaultRouterControllerHelpers;

    public function get()
    {
        $id = (int) $this->i();

        $activity = ActivityQuery::create()->findPk($id);

        $data = $activity->getData() === null ? [] : unserialize($activity->getData());
        $data['created_at'] = $activity->getCreatedAt();
        $data['id'] = $id;

        $reference = $this->s('start')->getActivity($activity->getCode());

        $amd = $reference->amd;
        $amd = explode('.', $amd);

        $this->getProxy()->forward($amd[0], $amd[1], $amd[2], $data);
    }
}