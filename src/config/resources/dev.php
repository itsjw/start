<?php

return [
    '_domains' => [
        [
            'domain' => 'start.dev',
            'bundle' => 'start'
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
];