<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\GridBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;


class MikyGridExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($config, $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.xml');

        foreach (['filter', 'action'] as $templatesCollectionName) {
            $templates = isset($config['templates'][$templatesCollectionName]) ? $config['templates'][$templatesCollectionName] : [];
            $container->setParameter('adevis.grid.templates.'.$templatesCollectionName, $templates);
        }

        $container->setParameter('adevis.grids_definitions', $config['grids']);

        $container->setAlias('adevis.grid.renderer', 'adevis.grid.renderer.twig');
        $container->setAlias('adevis.grid.data_extractor', 'adevis.grid.data_extractor.property_access');

        foreach ($config['drivers'] as $enabledDriver) {
            $path = sprintf('driver/%s.xml', $enabledDriver);
            $loader->load($path);
        }
    }
}
