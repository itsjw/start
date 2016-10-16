<?php

namespace Start\Controller;

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

        switch ($activity->getCode()) {
            case 10:
                $this->forward('_tile/text', 'amd', $data);
                break;
            case 20:
                $this->forward('_tile/markdown', 'amd', $data);
                break;
        }
    }

    public function post()
    {
        $id = (int) $this->i();

        $activity = ActivityQuery::create()->findPk($id);

        if ($activity) {
            $activity->setClosedAt(new \DateTime());
            $activity->save();
        }
    }
}