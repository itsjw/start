<?php

return [
    'perfumerlabs.start' => [
        'static' => 'http://static.start.dev'
    ],

    '_domains' => [
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
        'dsn' => 'pgsql:host=db;port=5432;dbname=naimi',
        'db_user' => 'postgres',
        'db_password' => 'root',
        'config_dir' => __DIR__ . '/../propel/' . ENV,
        'schema_dir' => __DIR__ . '/../propel/schema',
        'model_dir' => __DIR__ . '/../../Model',
        'migration_dir' => __DIR__ . '/../propel/migration',
    ],

    'dir' => [
        'log_file' => TMP_DIR . 'logs/example.log',
        'twig_cache' => TMP_DIR . 'twig',
        'file_cache' => TMP_DIR . 'cache/'
    ]
];
