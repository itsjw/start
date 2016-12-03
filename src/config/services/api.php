<?php

return [
    'perfumerlabs.start.api.router' => [
        'shared' => true,
        'class' => 'Perfumer\\Framework\\Router\\Http\\DefaultRouter',
        'arguments' => ['#bundle_resolver', [
            'data_type' => 'json'
        ]]
    ],

    'perfumerlabs.start.api.request' => [
        'class' => 'Perfumer\\Framework\\Proxy\\Request',
        'arguments' => ['$0', '$1', '$2', '$3', [
            'prefix' => 'Perfumerlabs\\Start\\Api',
            'suffix' => 'Controller'
        ]]
    ],

    'perfumerlabs.start.api.auth' => [
        'shared' => true,
        'class' => 'Perfumer\\Component\\Auth\\Authorization\\DatabaseAuthorization',
        'arguments' => ['#session', '#perfumerlabs.start.api.auth.token.http_header_handler', [
            'model' => '\\App\\Model\\User',
            'username_field' => 'username',
            'acl' => true,
            'application' => false,
            'update_gap' => 1800
        ]]
    ],

    'perfumerlabs.start.api.auth.token.http_header_handler' => [
        'shared' => true,
        'class' => 'Perfumer\\Component\\Session\\TokenHandler\\HttpHeaderHandler',
        'arguments' => [[
            'header' => 'HTTP_API_SESSION',
            'lifetime' => 60 * 86400
        ]]
    ],
];