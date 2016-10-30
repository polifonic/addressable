<?php

namespace Polifonic\Addressable\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('polifonic_addressable');

        $rootNode
            ->children()
                ->scalarNode('base_country')
                    ->defaultValue('US')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('ip_address')
                    ->defaultValue(null)
                ->end()
                ->arrayNode('geoip')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('provider')
                            ->defaultValue('polifonic.addressable.geoip.reader')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
