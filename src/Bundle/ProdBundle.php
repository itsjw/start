<?php

namespace Perfumerlabs\Start\Bundle;

use Perfumer\Component\Container\AbstractBundle;

class ProdBundle extends AbstractBundle
{
    public function getName()
    {
        return 'perfumerlabs/start/prod';
    }

    public function getDescription()
    {
        return 'PerfumerLabs Start prod bundle';
    }

    public function getDefinitionFiles()
    {
        return [
            __DIR__ . '/../Resource/config/services/prod.php'
        ];
    }

    public function getResourceFiles()
    {
        return [
            __DIR__ . '/../Resource/config/resources/prod.php'
        ];
    }
}
