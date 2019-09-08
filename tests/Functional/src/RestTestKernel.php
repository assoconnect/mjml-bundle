<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\Functional\App;

use Symfony\Component\Config\Loader\LoaderInterface;

class RestTestKernel extends TestKernel
{
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/../config/config_rest.yml');
    }
}
