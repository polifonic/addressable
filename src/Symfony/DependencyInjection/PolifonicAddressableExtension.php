<?php

namespace Polifonic\Addressable\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class PolifonicAddressableExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('polifonic.addressable.base_country', $config['base_country']);

        $container->setParameter('polifonic.addressable.ip_address', $config['ip_address']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');

        $container->setAlias('polifonic.addressable.geoip.provider', $config['geoip']['provider']);
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        if (true === isset($bundles['PropelBundle'])) {
            $this->configurePropelBundle($container, $config);
        }
    }

    /**
     * @param ContainerBuilder $container The service container
     */
    protected function configurePropelBundle(ContainerBuilder $container, $config)
    {
        $container->prependExtensionConfig(
            'propel',
            array(
                'build-properties' => array(
                    'propel.behavior.addressable.class' => 'Polifonic\Addressable\Propel\AddressableBehavior',
                )
            )
        );
    }
}
