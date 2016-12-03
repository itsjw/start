<?php

namespace Perfumerlabs\Start\Controller\_Tile;

use Perfumer\Framework\Controller\TemplateController;

class TextController extends TemplateController
{
    public function amd($title, $text, $created_at, $id)
    {
        $this->getView()->addVars([
            'title' => $title,
            'text' => $text,
            'created_at' => $created_at,
            'id' => $id
        ]);
    }
}