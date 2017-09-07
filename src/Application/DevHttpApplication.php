<?php

namespace Perfumerlabs\Start\Application;

use Perfumer\Component\Container\Container;
use Perfumer\Framework\Application\AbstractApplication;
use Perfumer\Package\Framework\Bundle\HttpBundle as PerfumerHttpBundle;
use Perfumerlabs\Start\Bundle\ApiBundle;
use Perfumerlabs\Start\Bundle\CommonBundle;
use Perfumerlabs\Start\Bundle\ControllerBundle;
use Perfumerlabs\Start\Bundle\DevBundle;

class DevHttpApplication extends AbstractApplication
{
    public function getBundles()
    {
        return [
            new PerfumerHttpBundle(),
            new CommonBundle(),
            new ControllerBundle(),
            new ApiBundle(),
            new DevBundle()
        ];
    }

    protected function before()
    {
        date_default_timezone_set('Asia/Almaty');

        define('ENV', 'dev');

        define('TMP_DIR', __DIR__ . '/../../tmp/');
    }

    protected function after(Container $container)
    {
        $container->get('propel.service_container');
    }
}