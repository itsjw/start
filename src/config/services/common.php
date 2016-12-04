<?php

return [
    'perfumerlabs.start' => [
        'shared' => true,
        'class' => 'Perfumerlabs\\Start\\Service\\Start',
        'after' => function(\Perfumer\Component\Container\Container $container, \Perfumerlabs\Start\Service\Start $start) {
            $start->addActivity(new \Perfumerlabs\Start\Service\Activity\TextActivity());
            $start->addActivity(new \Perfumerlabs\Start\Service\Activity\MarkdownActivity());
            $start->addActivity(new \Perfumerlabs\Start\Service\Activity\IframeActivity());
        }
    ],

    'perfumerlabs.activity' => [
        'shared' => true,
        'class' => 'Perfumerlabs\\Start\\Service\\Activity'
    ]
];