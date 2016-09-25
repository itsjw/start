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

        switch ($fragment->getTile()) {
            case 'text':
                $this->forward('_tile/text', 'amd', ['Text', 'text']);
                break;
            case 'markdown':
                $this->forward('_tile/markdown', 'amd', ['Markdown', 'text']);
                break;
        }
    }
}