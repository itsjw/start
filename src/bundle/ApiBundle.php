<?php

namespace Start\Bundle;

use Perfumer\Component\Container\AbstractBundle;

class ApiBundle extends AbstractBundle
{
    public function getName()
    {
        return 'api';
    }

    public function getDescription()
    {
        return 'api';
    }


    public function getAliases()
    {
        return [
            'auth' => 'auth.api',
            'router' => 'start.api_router',
            'request' => 'start.api_request',
            'view' => 'view.status'
        ];
    }
}
