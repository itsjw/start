<?php

return [
    'perfumerlabs.start' => [
        'static' => 'http://static.perfumerlabs.com/tgniqmw5yt'
    ],

    '_domains' => [
        [
            'domain' => 'start.perfumerlabs.com',
            'bundle' => 'perfumerlabs/start/controller'
        ],
        [
            'domain' => 'start',
            'bundle' => 'perfumerlabs/start/command'
        ]
    ],

    'twig' => [
        'debug' => true
    ],

    'propel' => [
        'project' => 'start',
        'dsn' => 'pgsql:host=localhost;port=5432;dbname=start',
        'db_user' => 'postgres',
        'db_password' => '',
        'config_dir' => __DIR__ . '/../../propel/' . ENV,
        'schema_dir' => __DIR__ . '/../../propel/schema',
        'model_dir' => __DIR__ . '/../../../Model',
        'migration_dir' => __DIR__ . '/../../propel/migration',
    ],

    'dir' => [
        'log_file' => TMP_DIR . 'logs/example.log',
        'twig_cache' => TMP_DIR . 'twig',
        'file_cache' => TMP_DIR . 'cache/'
    ]
];
