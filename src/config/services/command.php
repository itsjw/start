<?php

return [
    'perfumerlabs.start.command.request' => [
        'class' => 'Perfumer\\Framework\\Proxy\\Request',
        'arguments' => ['$0', '$1', '$2', '$3', [
            'prefix' => 'Perfumerlabs\\Start\\Command',
            'suffix' => 'Command'
        ]]
    ]
];