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

use Miky\Bundle\GridBundle\Doctrine\ORM\Driver as DoctrineORMDriver;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
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
        $rootNode = $treeBuilder->root('miky_grid');


        $this->addTemplatesSection($rootNode);
        $this->addGridsSection($rootNode);

        return $treeBuilder;
    }



    /**
     * @param ArrayNodeDefinition $node
     */
    private function addTemplatesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('templates')
                    ->children()
                        ->scalarNode("batch_action")->isRequired()->end()
                        ->arrayNode('filter')
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('action')
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addGridsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('grids')
                    ->useAttributeAsKey('code')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('resource')->isRequired()->cannotBeEmpty()->end()
                            ->arrayNode('driver')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->arrayNode('options')
                                        ->prototype('variable')->end()
                                        ->defaultValue([])
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('sorting')
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('path')->isRequired()->cannotBeEmpty()->end()
                                        ->enumNode('direction')->values(['asc', 'desc'])->defaultValue('desc')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('fields')
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                                        ->scalarNode('label')->cannotBeEmpty()->end()
                                        ->scalarNode('path')->cannotBeEmpty()->end()
                                        ->arrayNode('options')
                                            ->prototype('variable')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('filters')
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                                        ->scalarNode('label')->cannotBeEmpty()->end()
                                        ->arrayNode('options')
                                            ->prototype('variable')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('actions')
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->useAttributeAsKey('name')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('type')->isRequired()->end()
                                            ->scalarNode('label')->end()
                                            ->arrayNode('options')
                                                ->prototype('variable')->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('batch_actions')
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                        ->children()
                                            ->scalarNode('label')->isRequired()->end()
                                            ->arrayNode('options')
                                                ->prototype('variable')->end()
                                            ->end()
                                         ->end()
                                    ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
