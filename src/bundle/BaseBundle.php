<?php

namespace Perfumerlabs\Start\Bundle;

use Perfumer\Component\Container\AbstractBundle;

abstract class BaseBundle extends AbstractBundle
{
    public function getName()
    {
        return 'start';
    }

    public function getDescription()
    {
        return 'Start package bundle';
    }

    public function getDefinitionFiles()
    {
        return [
            __DIR__ . '/../config/services/shared.php',
            __DIR__ . '/../config/services/' . ENV . '.php',
        ];
    }

    public function getResourceFiles()
    {
        return [
            __DIR__ . '/../config/resources/shared.php',
            __DIR__ . '/../config/resources/' . ENV . '.php',
        ];
    }
}
