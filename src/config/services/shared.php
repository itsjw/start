<?php

return [
    'start' => [
        'shared' => true,
        'class' => 'Start\\Service\\Start',
        'after' => function(\Perfumer\Component\Container\Container $container, \Start\Service\Start $start) {
            $start->addActivity(new \Start\Service\Activity\TextActivity());
            $start->addActivity(new \Start\Service\Activity\MarkdownActivity());
        }
    ],

    'auth' => [
        'shared' => true,
        'class' => 'Perfumer\\Component\\Auth\\Authorization\\DatabaseAuthorization',
        'arguments' => ['#session', '#auth.token.cookie_handler', [
            'username_field' => 'username',
            'acl' => true,
            'application' => false,
            'update_gap' => 1800
        ]]
    ],

    'auth.token.cookie_handler' => [
        'shared' => true,
        'class' => 'Perfumer\\Component\\Session\\TokenHandler\\CookieHandler',
        'arguments' => ['#cookie', [
            'lifetime' => 7 * 86400
        ]]
    ],

    'start.http_router' => [
        'shared' => true,
        'class' => 'Perfumer\\Framework\\Router\\Http\\DefaultRouter',
        'arguments' => ['#bundle_resolver']
    ],

    'start.http_request' => [
        'class' => 'Perfumer\\Framework\\Proxy\\Request',
        'arguments' => ['$0', '$1', '$2', '$3', [
            'prefix' => 'Start\\Controller',
            'suffix' => 'Controller'
        ]]
    ],

    'start.api_router' => [
        'shared' => true,
        'class' => 'Perfumer\\Framework\\Router\\Http\\DefaultRouter',
        'arguments' => ['#bundle_resolver', [
            'data_type' => 'json'
        ]]
    ],

    'start.api_request' => [
        'class' => 'Perfumer\\Framework\\Proxy\\Request',
        'arguments' => ['$0', '$1', '$2', '$3', [
            'prefix' => 'Start\\Api',
            'suffix' => 'Controller'
        ]]
    ],

    'start.console_router' => [
        'shared' => true,
        'class' => 'Perfumer\\Framework\\Router\\ConsoleRouter'
    ],

    'start.console_request' => [
        'class' => 'Perfumer\\Framework\\Proxy\\Request',
        'arguments' => ['$0', '$1', '$2', '$3', [
            'prefix' => 'Start\\Command',
            'suffix' => 'Command'
        ]]
    ],

    'start.view' => [
        'class' => 'Perfumer\\Framework\\View\\TemplateView',
        'arguments' => ['#twig', '#start.template_provider']
    ],

    'start.template_provider' => [
        'shared' => true,
        'class' => 'Perfumer\\Framework\\View\\TemplateProvider\\TwigFilesystemProvider',
        'arguments' => ['#twig.filesystem_loader', __DIR__ . '/../../view', 'start']
    ],

    'activity' => [
        'shared' => true,
        'class' => 'Start\\Service\\Activity'
    ],

    'auth.api' => [
        'shared' => true,
        'class' => 'Perfumer\\Component\\Auth\\Authorization\\DatabaseAuthorization',
        'arguments' => ['#session', '#auth.token.http_header_handler', [
            'username_field' => 'username',
            'acl' => true,
            'application' => false,
            'update_gap' => 1800
        ]]
    ],

    'auth.token.http_header_handler' => [
        'shared' => true,
        'class' => 'Perfumer\\Component\\Session\\TokenHandler\\HttpHeaderHandler',
        'arguments' => [[
            'header' => 'HTTP_API_SESSION',
            'lifetime' => 60 * 86400
        ]]
    ],

    'twig' => [
        'shared' => true,
        'class' => 'Twig_Environment',
        'arguments' => ['#twig.filesystem_loader', [
            'cache' => '@dir/twig_cache',
            'debug' => '@twig/debug'
        ]],
        'after' => function(\Perfumer\Component\Container\Container $container, \Twig_Environment $twig) {
            $twig->addExtension($container->get('twig.framework_extension'));
            $twig->addExtension($container->get('twig.http_router_extension'));
        }
    ],
];