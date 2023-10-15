<?php

namespace App\Tests\Core\Transfer\Strategy;

use App\Connector\Memory\Connector\CustomerConnector;
use App\Core\Connection\Connection;
use App\Core\ConnectorInterface\Repository\RepositoryInterface;
use App\Core\Transfer\Strategy\BatchStrategy;
use App\Tests\AppBase;

class BatchStrategyTest extends AppBase
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

        $transferStrategy = new BatchStrategy(
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
}