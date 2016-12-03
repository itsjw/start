<?php

require __DIR__ . '/../vendor/autoload.php';

$application = new \Perfumerlabs\Start\Application\DevHttpApplication();
$application->run();