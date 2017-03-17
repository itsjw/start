<?php

return [
    'perfumerlabs.start.controller.auth' => [
        'shared' => true,
        'class' => 'Perfumer\\Component\\Auth\\Authentication',
        'arguments' => ['#perfumerlabs.start.controller.session.user', '#perfumerlabs.start.controller.auth.data_provider.user', '#perfumerlabs.start.controller.auth.token.cookie_handler']
    ],

    'perfumerlabs.start.controller.auth.data_provider.user' => [
        'shared' => true,
        'class' => 'Perfumerlabs\\Start\\Service\\Auth\\UserDataProvider'
    ],

    'perfumerlabs.start.controller.session.user' => [
        'shared' => true,
        'class' => 'Perfumer\\Component\\Auth\\Session',
        'arguments' => ['#cache.memcache', [
            'cache_prefix' => '_session_user'
        ]]
    ],

    'perfumerlabs.start.controller.auth.token.cookie_handler' => [
        'shared' => true,
        'class' => 'Perfumer\\Component\\Auth\\TokenProvider\\CookieProvider',
        'arguments' => ['#cookie', [
            'lifetime' => 7 * 86400
        ]]
    ],

    'perfumerlabs.start.controller.router' => [
        'shared' => true,
        'class' => 'Perfumer\\Framework\\Router\\Http\\DefaultRouter',
        'arguments' => ['#bundle_resolver', [
            'data_type' => 'json'
        ]]
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