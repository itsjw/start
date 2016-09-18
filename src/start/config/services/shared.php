<?php

return [
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
    ]
];