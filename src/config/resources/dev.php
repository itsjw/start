<?php

return [
    '_domains' => [
        [
            'domain' => 'start.dev',
            'prefix' => '/api',
            'bundle' => 'perfumerlabs/start/api'
        ],
        [
            'domain' => 'start.dev',
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
        'dsn' => 'pgsql:host=localhost;port=5433;dbname=start',
        'db_user' => 'postgres',
        'db_password' => 'root',
        'config_dir' => __DIR__ . '/../propel/' . ENV,
        'schema_dir' => __DIR__ . '/../propel/schema',
        'model_dir' => __DIR__ . '/../../model',
        'migration_dir' => __DIR__ . '/../propel/migration',
    ],

    'dir' => [
        'log_file' => TMP_DIR . 'logs/example.log',
        'twig_cache' => TMP_DIR . 'twig',
        'file_cache' => TMP_DIR . 'cache/'
    ]
];