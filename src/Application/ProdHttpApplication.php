<?php

namespace Perfumerlabs\Start\Application;

use Perfumer\Component\Container\Container;
use Perfumer\Framework\Application\AbstractApplication;
use Perfumer\Package\Framework\Bundle\HttpBundle as PerfumerHttpBundle;
use Perfumerlabs\Start\Bundle\CommonBundle;
use Perfumerlabs\Start\Bundle\ControllerBundle;
use Perfumerlabs\Start\Bundle\ProdBundle;

class ProdHttpApplication extends AbstractApplication
{
    public function getBundles()
    {
        return [
            new PerfumerHttpBundle(),
            new CommonBundle(),
            new ControllerBundle(),
            new ProdBundle()
        ];
    }

    protected function before()
    {
        date_default_timezone_set('Asia/Almaty');

        define('ENV', 'prod');

        define('TMP_DIR', __DIR__ . '/../../tmp/');
    }

    protected function after(Container $container)
    {
        $container->get('propel.service_container');
    }
}
