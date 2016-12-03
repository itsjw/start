<?php

namespace Perfumerlabs\Start\Bundle;

use Perfumer\Component\Container\AbstractBundle;

class CommandBundle extends AbstractBundle
{
    public function getName()
    {
        return 'perfumerlabs/start/command';
    }

    public function getDescription()
    {
        return 'PerfumerLabs Start command bundle';
    }

    public function getDefinitionFiles()
    {
        return [
            __DIR__ . '/../config/services/command.php'
        ];
    }

    public function getAliases()
    {
        return [
            'router' => 'router.console',
            'request' => 'perfumerlabs.start.command.request'
        ];
    }
}
