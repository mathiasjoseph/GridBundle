<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\GridBundle\Tests\DependencyInjection;

use Miky\Bundle\GridBundle\DependencyInjection\MikyGridExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;


class MikyGridExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function it_sets_configured_grids_as_parameter()
    {
        $this->load([
            'grids' => [
                'miky_admin_tax_category' => [
                    'driver' => [
                        'name' => 'doctrine/orm',
                        'options' => [
                            'class' => 'Miky\Component\Taxation\Model\TaxCategory'
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertContainerBuilderHasParameter('miky.grids_definitions', [
            'miky_admin_tax_category' => [
                'driver' => [
                    'name' => 'doctrine/orm',
                    'options' => [
                        'class' => 'Miky\Component\Taxation\Model\TaxCategory'
                    ]
                ],
                'sorting' => [],
                'fields' => [],
                'filters' => [],
                'actions' => [],
            ]
        ]);
    }

    /**
     * @test
     */
    public function it_aliases_default_services()
    {
        $this->load([]);

        $this->assertContainerBuilderHasAlias('miky.grid.renderer', 'miky.grid.renderer.twig');
        $this->assertContainerBuilderHasAlias('miky.grid.data_extractor', 'miky.grid.data_extractor.property_access');
    }

    /**
     * @test
     */
    public function it_always_defines_template_parameters()
    {
        $this->load([]);

        $this->assertContainerBuilderHasParameter('miky.grid.templates.filter', []);
        $this->assertContainerBuilderHasParameter('miky.grid.templates.action', []);
    }

    /**
     * @test
     */
    public function it_sets_filter_templates_as_parameters()
    {
        $this->load([
            'templates' => [
                'filter' => [
                    'string' => 'AppBundle:Grid/Filter:string.html.twig',
                    'date' => 'AppBundle:Grid/Filter:date.html.twig',
                ]
            ]
        ]);

        $this->assertContainerBuilderHasParameter('miky.grid.templates.filter', [
            'string' => 'AppBundle:Grid/Filter:string.html.twig',
            'date' => 'AppBundle:Grid/Filter:date.html.twig',
        ]);
    }

    /**
     * @test
     */
    public function it_sets_action_templates_as_parameters()
    {
        $this->load([
            'templates' => [
                'action' => [
                    'create' => 'AppBundle:Grid/Filter:create.html.twig',
                    'update' => 'AppBundle:Grid/Filter:update.html.twig',
                ]
            ]
        ]);

        $this->assertContainerBuilderHasParameter('miky.grid.templates.action', [
            'create' => 'AppBundle:Grid/Filter:create.html.twig',
            'update' => 'AppBundle:Grid/Filter:update.html.twig',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [
            new MikyGridExtension(),
        ];
    }
}
