<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AssoconnectMJMLExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // Loading config.yml file
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');
    }
}
