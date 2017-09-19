<?php

return [
    'propel' => [
        'database' => [
            'connections' => [
                'start' => [
                    'adapter' => 'pgsql',
                    'dsn' => 'pgsql:host=db;port=5432;dbname=start',
                    'user' => 'postgres',
                    'password' => '',
                    'settings' => [
                        'charset' => 'utf8',
                        'queries' => [
                            'utf8' => "SET NAMES 'UTF8'"
                        ]
                    ],
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'start',
            'connections' => ['start']
        ],
        'generator' => [
            'defaultConnection' => 'start',
            'connections' => ['start']
        ]
    ]
];
