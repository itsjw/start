<?php

namespace Start\Controller\_Tile;

use Perfumer\Framework\Controller\TemplateController;

class MarkdownController extends TemplateController
{
    public function amd($title, $text, $created_at)
    {
        $this->getView()->addVars([
            'title' => $title,
            'text' => $text,
            'created_at' => $created_at,
        ]);
    }
}