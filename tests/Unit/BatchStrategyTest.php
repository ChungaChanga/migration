<?php

namespace App\Tests\Unit;

use App\Connector\Memory\Connector\CustomerConnector;
use App\Core\Connection\Connection;
use App\Core\ConnectorInterface\Repository\RepositoryInterface;
use App\Core\Migration\TransferStrategy;
use App\Tests\UnitBase;

class BatchStrategyTest extends UnitBase
{
    public function testTransferEntitiesCount()
    {
        $connection = new Connection(
            new CustomerConnector(),
            new CustomerConnector()
        );

        /**@var RepositoryInterface $sourceRepository */
        $connection->getSourceConnector()->getRepository()
            ->create(self::CUSTOMER_REPOSITORY_NINE_ENTITIES_STATES);

        $this->assertEquals(
            0,
            count($connection->getDestinationConnector()->getRepository()->fetch(0, 100))
        );

        $transferStrategy = new TransferStrategy(
            $connection,
            1,
            2,
            4,
        );

        set_time_limit(5);
        $transferStrategy->start();

        $this->assertEquals(
            8,
            count($connection->getDestinationConnector()->getRepository()->fetch(0, 100))
        );

    }

    public function testTransferEntitiesValues()
    {
        $connection = new Connection(
            new CustomerConnector(),
            new CustomerConnector()
        );

        /**@var RepositoryInterface $sourceRepository */
        $connection->getSourceConnector()->getRepository()
            ->create(self::CUSTOMER_REPOSITORY_NINE_ENTITIES_STATES);

        $transferStrategy = new TransferStrategy(
            $connection,
            1,
            2,
            4,
            delaySeconds: 1
        );

        set_time_limit(15);
        $transferStrategy->start();

        $this->assertEquals(1, $connection->getDestinationConnector()->getRepository()->fetch(0, 1)[0]['id']);
        $this->assertEquals(4, $connection->getDestinationConnector()->getRepository()->fetch(3, 4)[0]['id']);

    }

}