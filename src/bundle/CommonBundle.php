<?php

namespace Perfumerlabs\Start\Bundle;

use Perfumer\Component\Container\AbstractBundle;

class CommonBundle extends AbstractBundle
{
    public function getName()
    {
        return 'perfumerlabs/start/common';
    }

    public function getDescription()
    {
        return 'PerfumerLabs Start common bundle';
    }

    public function getDefinitionFiles()
    {
        return [
            __DIR__ . '/../config/services/common.php'
        ];
    }
}
