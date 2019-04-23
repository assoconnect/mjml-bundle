<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\DependencyInjection;

use Assoconnect\MJMLBundle\Tag\TagInterface;
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

        // all classes implementing TagInterface will be tagged with assoconnect_mjml.custom_tag
        // so the bundle user does not need to tag these
        $container->registerForAutoconfiguration(TagInterface::class)
            ->addTag('assoconnect_mjml.custom_tag');
    }
}
