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

        $reference = $this->getContainer()->getResource('activities');
print_r($reference);
        if (!isset($reference[$activity->getCode()])) {
            $this->pageNotFoundException();
        }

        $request = $reference[$activity->getCode()]['request'];
        $request = explode('.', $request);

        $this->getProxy()->forward($request[0], $request[1], $request[2], $data);
    }
}