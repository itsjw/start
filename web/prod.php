<?php

require __DIR__ . '/../vendor/autoload.php';

$application = new \Perfumerlabs\Start\Application\ProdHttpApplication();
$application->run();