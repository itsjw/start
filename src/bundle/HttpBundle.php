<?php

namespace Start\Bundle;

class HttpBundle extends BaseBundle
{
    public function getAliases()
    {
        return [
            'auth' => 'auth',
            'router' => 'start.http_router',
            'request' => 'start.http_request',
            'view' => 'start.view',
            'template_provider' => 'start.template_provider'
        ];
    }
}
