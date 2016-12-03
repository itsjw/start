<?php

return [
    'cache' => [
        'alias' => 'cache.ephemeral'
    ],

    'start' => [
        'alias' => 'perfumerlabs.start'
    ],

    'activity' => [
        'alias' => 'perfumerlabs.activity'
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