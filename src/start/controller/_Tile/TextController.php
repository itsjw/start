<?php

namespace Start\Controller\_Tile;

use Perfumer\Framework\Controller\TemplateController;

class TextController extends TemplateController
{
    public function amd($title, $text)
    {
        $this->getView()->addVars([
            'title' => $title,
            'text' => $text
        ]);
    }
}