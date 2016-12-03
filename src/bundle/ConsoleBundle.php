<?php

namespace Perfumerlabs\Start\Bundle;

class ConsoleBundle extends BaseBundle
{
    public function getAliases()
    {
        return [
            'router' => 'start.console_router',
            'request' => 'start.console_request'
        ];
    }
}
