<?php

namespace Perfumerlabs\Start\Controller;

use Perfumer\Framework\Controller\PlainController;
use Perfumer\Framework\Router\Http\DefaultRouterControllerHelpers;
use Perfumerlabs\Start\Model\DutyQuery;

class DutyController extends PlainController
{
    use DefaultRouterControllerHelpers;

    public function get()
    {
        $id = (int) $this->i();

        $duty = DutyQuery::create()->findPk($id);

        if (!$duty) {
            $this->pageNotFoundException();
        }

        if (!$duty->getActivity()->getAmd()) {
            $this->pageNotFoundException();
        }

        $amd = $duty->getActivity()->getAmd();
        $amd = explode('.', $amd);

        $arguments = [
            'data' => $duty->getData() === null ? [] : unserialize($duty->getData()),
            'created_at' => $duty->getCreatedAt(),
            'id' => $id
        ];

        $this->getProxy()->forward($amd[0], $amd[1], $amd[2], $arguments);
    }
}