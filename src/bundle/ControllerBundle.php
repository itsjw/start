<?php

namespace Perfumerlabs\Start\Bundle;

use Perfumer\Component\Container\AbstractBundle;

class ControllerBundle extends AbstractBundle
{
    public function getName()
    {
        return 'perfumerlabs/start/controller';
    }

    public function getDescription()
    {
        return 'PerfumerLabs Start controller bundle';
    }

    public function getDefinitionFiles()
    {
        return [
            __DIR__ . '/../config/services/controller.php'
        ];
    }

    public function getAliases()
    {
        return [
            'auth' => 'perfumerlabs.start.controller.auth',
            'router' => 'perfumerlabs.start.controller.router',
            'request' => 'perfumerlabs.start.controller.request',
            'view' => 'perfumerlabs.start.controller.view',
            'template_provider' => 'perfumerlabs.start.controller.template_provider'
        ];
    }
}
