<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\GridBundle\Doctrine\DBAL;

use Miky\Component\Grid\Data\DriverInterface;
use Miky\Component\Grid\Parameters;
use Doctrine\DBAL\Connection;


class Driver implements DriverInterface
{
    const NAME = 'doctrine/dbal';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataSource(array $configuration, Parameters $parameters)
    {
        if (!array_key_exists('table', $configuration)) {
            throw new \InvalidArgumentException('"table" must be configured.');
        }

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('o.*')
            ->from($configuration['table'], 'o')
        ;

        foreach ($configuration['aliases'] as $column => $alias) {
            $queryBuilder->addSelect(sprintf('o.%s as %s', $column, $alias));
        }

        return new DataSource($queryBuilder);
    }
}
