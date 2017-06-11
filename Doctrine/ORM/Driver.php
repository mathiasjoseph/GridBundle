<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\GridBundle\Doctrine\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Miky\Component\Grid\Data\DriverInterface;
use Miky\Component\Grid\Definition\Grid;
use Miky\Component\Grid\Parameters;
use Miky\Component\Resource\Metadata\RegistryInterface;


class Driver implements DriverInterface
{


    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, RegistryInterface $registry)
    {
        $this->entityManager = $entityManager;
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataSource(Grid $grid, Parameters $parameters)
    {
        $resource = $this->registry->get($grid->getResourceAlias());
        $class = $resource->getParameter('classes')['model'];
        $configuration = $grid->getDriverConfiguration();
        $repository = $this->entityManager->getRepository($class);
        if (isset($configuration['repository']['method'])) {
            $callable = [$repository, $configuration['repository']['method']];
            $arguments = isset($configuration['repository']['arguments']) ? $configuration['repository']['arguments'] : [];

            $queryBuilder = call_user_func_array($callable, $arguments);
        } else {
            $queryBuilder = $repository->createQueryBuilder('o');
        }

        return new DataSource($queryBuilder);
    }
}
