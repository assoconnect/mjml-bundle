<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\Functional\App;

use Assoconnect\MJMLBundle\AssoconnectMJMLBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    public function registerBundles()
    {
        yield new FrameworkBundle();
        yield new AssoconnectMJMLBundle();
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/../config/config.yml');
    }

    public function getProjectDir()
    {
        return __DIR__ . '/..';
    }

    public function getCacheDir()
    {
        return __DIR__ . '/../var/cache';
    }

    public function getLogDir()
    {
        return __DIR__ . '/../var/log';
    }
}
