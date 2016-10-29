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

        $container->setParameter('polifonic.addressable.default_local_ip', $config['default_local_ip']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        if (true === isset($bundles['MaxmindGeoipBundle'])) {
            $this->configureMaxmindGeoipBundle($container, $config);
        }
    }

    /**
     * @param ContainerBuilder $container The service container
     */
    protected function configureMaxmindGeoipBundle(ContainerBuilder $container, $config)
    {
        $container->prependExtensionConfig(
            'maxmind_geoip',
            array(
                'data_file_path' => '%kernel.root_dir%/../vendor/polifonic/addressable-bundle/Resources/geoip/GeoIP.dat',
            )
        );
    }
}
