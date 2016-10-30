<?php

return [
    'tiles' => [
        'text' => [
            'uri' => '/_tile/text'
        ],
        'markdown' => [
            'uri' => '/_tile/markdown'
        ]
    ],

    'dir' => [
        'log_file' => TMP_DIR . 'logs/example.log',
        'twig_cache' => TMP_DIR . 'twig',
        'file_cache' => TMP_DIR . 'cache/'
    ],

    'activities' => [
        10 => [
            'request' => 'start._tile/text.amd'
        ],
        20 => [
            'request' => 'start._tile/markdown.amd'
        ]
    ]
];