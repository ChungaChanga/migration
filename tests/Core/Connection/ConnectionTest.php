<?php

namespace App\Tests\Core\Connection;

use App\Connector\Memory\Factory\CustomerFactory;
use App\Core\Connection\Connection;
use App\Core\ConnectorInterface\Repository\RepositoryInterface;
use App\Tests\AppBase;

class ConnectionTest extends AppBase
{
    public function testTransferEntitiesCount()
    {
        $connection = new Connection(
            new CustomerFactory(),
            new CustomerFactory()
        );

        /**@var RepositoryInterface $sourceRepository */
        $connection->getSourceRepository()->create(self::CUSTOMER_REPOSITORY_NINE_ENTITIES_STATES);

        $this->assertEquals(
            0,
            count($connection->getDestinationRepository()->fetch(0, 100))
        );

        $connection->transferStart(2);

        $this->assertEquals(
            9,
            count($connection->getDestinationRepository()->fetch(0, 100))
        );

    }
}