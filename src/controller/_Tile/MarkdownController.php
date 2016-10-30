<?php

namespace Start\Controller\_Tile;

use Perfumer\Framework\Controller\TemplateController;

class MarkdownController extends TemplateController
{
    public function amd($text, $created_at, $id)
    {
        $this->getView()->addVars([
            'text' => (new \Parsedown())->text($text),
            'created_at' => $created_at,
            'id' => $id,
        ]);
    }
}