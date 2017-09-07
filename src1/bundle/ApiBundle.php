<?php

namespace Perfumerlabs\Start\Bundle;

use Perfumer\Component\Container\AbstractBundle;

class ApiBundle extends AbstractBundle
{
    public function getName()
    {
        return 'perfumerlabs/start/api';
    }

    public function getDescription()
    {
        return 'PerfumerLabs Start api bundle';
    }

    public function getDefinitionFiles()
    {
        return [
            __DIR__ . '/../config/services/api.php'
        ];
    }

    public function getAliases()
    {
        return [
            'auth' => 'perfumerlabs.start.api.auth',
            'router' => 'perfumerlabs.start.api.router',
            'request' => 'perfumerlabs.start.api.request',
            'view' => 'view.status'
        ];
    }
}
