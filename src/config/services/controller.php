<?php

return [
    'perfumerlabs.start.controller.auth' => [
        'shared' => true,
        'class' => 'Perfumer\\Component\\Auth\\Authorization\\DatabaseAuthorization',
        'arguments' => ['#session', '#perfumerlabs.start.controller.auth.token.cookie_handler', [
            'model' => '\\App\\Model\\User',
            'username_field' => 'username',
            'acl' => true,
            'application' => false,
            'update_gap' => 1800
        ]]
    ],

    'perfumerlabs.start.controller.auth.token.cookie_handler' => [
        'shared' => true,
        'class' => 'Perfumer\\Component\\Session\\TokenHandler\\CookieHandler',
        'arguments' => ['#cookie', [
            'lifetime' => 7 * 86400
        ]]
    ],

    'perfumerlabs.start.controller.router' => [
        'shared' => true,
        'class' => 'Perfumer\\Framework\\Router\\Http\\DefaultRouter',
        'arguments' => ['#bundle_resolver']
    ],

    'perfumerlabs.start.controller.request' => [
        'class' => 'Perfumer\\Framework\\Proxy\\Request',
        'arguments' => ['$0', '$1', '$2', '$3', [
            'prefix' => 'Perfumerlabs\\Start\\Controller',
            'suffix' => 'Controller'
        ]]
    ],

    'perfumerlabs.start.controller.view' => [
        'class' => 'Perfumer\\Framework\\View\\TemplateView',
        'arguments' => ['#twig', '#perfumerlabs.start.controller.template_provider']
    ],

    'perfumerlabs.start.controller.template_provider' => [
        'shared' => true,
        'class' => 'Perfumer\\Framework\\View\\TemplateProvider\\TwigFilesystemProvider',
        'arguments' => ['#twig.filesystem_loader', __DIR__ . '/../../view', 'start']
    ],
];