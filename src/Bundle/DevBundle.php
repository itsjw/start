<?php

namespace Perfumerlabs\Start\Bundle;

use Perfumer\Component\Container\AbstractBundle;

class DevBundle extends AbstractBundle
{
    public function getName()
    {
        return 'perfumerlabs/start/dev';
    }

    public function getDescription()
    {
        return 'PerfumerLabs Start dev bundle';
    }

    public function getDefinitionFiles()
    {
        return [
            __DIR__ . '/../Resource/config/services/dev.php'
        ];
    }

    public function getResourceFiles()
    {
        return [
            __DIR__ . '/../Resource/config/resources/dev.php'
        ];
    }
}
