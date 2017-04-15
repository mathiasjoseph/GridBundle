<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\GridBundle;

use Miky\Bundle\GridBundle\DependencyInjection\Compiler\RegisterDriversPass;
use Miky\Bundle\GridBundle\DependencyInjection\Compiler\RegisterFieldTypesPass;
use Miky\Bundle\GridBundle\DependencyInjection\Compiler\RegisterFiltersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;


class MikyGridBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterDriversPass());
        $container->addCompilerPass(new RegisterFiltersPass());
        $container->addCompilerPass(new RegisterFieldTypesPass());
    }
}
