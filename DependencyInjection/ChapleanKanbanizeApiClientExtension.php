<?php

namespace Chaplean\Bundle\KanbanizeApiClientBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link https://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ChapleanKanbanizeApiClientExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @return void
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * Prepend configuration to avoid requesting injection of configuration inside projects
     *
     * @link https://symfony.com/doc/4.1/bundles/prepend_extension.html
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function prepend(ContainerBuilder $container)
    {
        $config = [
            'clients' => [
                'kanbanize_api_v1' => null,
                'kanbanize_api_v2' => null
            ]
        ];

        // Add custom configuration for 8points guzzle
        $container->prependExtensionConfig('eight_points_guzzle', $config);
    }
}
