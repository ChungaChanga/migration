<?php

namespace App\Tests\Core\Transfer\Strategy;

use App\Connector\Memory\Connector\CustomerConnector;
use App\Core\Connection\Connection;
use App\Core\ConnectorInterface\Repository\RepositoryInterface;
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
        $sourceRepository = $connection->getSourceConnector()->createRepository();
        $sourceRepository->create(self::CUSTOMER_REPOSITORY_NINE_ENTITIES_STATES);

        $destinationRepository = $connection->getDestinationConnector()->createRepository();

        $this->assertEquals(
            0,
            count($destinationRepository->fetch(0, 100))
        );

        $connection->transferStart(2);

        $this->assertEquals(
            9,
            count($connection->getDestinationRepository()->fetch(0, 100))
        );

    }
}