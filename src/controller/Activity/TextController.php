<?php

namespace Perfumerlabs\Start\Controller\Activity;

use Perfumer\Framework\Controller\TemplateController;

class TextController extends TemplateController
{
    public function amd($data, $created_at, $id)
    {
        $this->getView()->addVars([
            'title' => $data['title'] ?? '',
            'text' => $data['text'] ?? '',
            'created_at' => $created_at,
            'id' => $id
        ]);
    }
}