<?php

namespace Perfumerlabs\Start\Controller\Activity;

use Perfumer\Framework\Controller\TemplateController;

class MarkdownController extends TemplateController
{
    public function amd($data, $created_at, $id)
    {
        $this->getView()->addVars([
            'text' => (new \Parsedown())->text($data['text'] ?? ''),
            'created_at' => $created_at,
            'id' => $id,
        ]);
    }
}