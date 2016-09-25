<?php

namespace Start\Controller;

use App\Model\FragmentQuery;
use Perfumer\Framework\Controller\PlainController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;

class FragmentController extends PlainController
{
    use DefaultRouterControllerHelpers;

    public function get()
    {
        $id = (int) $this->i();

        $fragment = FragmentQuery::create()->findPk($id);

        $data = $fragment->getData() === null ? [] : unserialize($fragment->getData());
        $data['created_at'] = $fragment->getCreatedAt();

        switch ($fragment->getTile()) {
            case 'text':
                $this->forward('_tile/text', 'amd', $data);
                break;
            case 'markdown':
                $this->forward('_tile/markdown', 'amd', $data);
                break;
        }
    }
}