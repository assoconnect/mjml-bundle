<?php

namespace Assoconnect\MJMLBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('assoconnect_mjml');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('template_paths')
                    ->beforeNormalization()
                        ->ifString()->then(function ($v) {
                            return [$v];
                        })
                        ->end()
                    ->prototype('scalar')->end()
                    ->defaultValue(['/templates/mjml'])
                ->end() // template_paths
                ->variableNode('rest_mjml_compiler_host')
                    ->defaultValue('http://127.0.0.1:3000')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
