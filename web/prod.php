<?php

require __DIR__ . '/../vendor/autoload.php';

$application = new \Start\Application\ProdHttpApplication();
$application->run();