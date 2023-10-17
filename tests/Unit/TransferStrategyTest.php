<?php

namespace App\Tests\Unit;

use App\Connector\Memory\Connector\CustomerConnector;
use App\Core\Connection\Connection;
use App\Core\ConnectorAbstract\Repository\RepositoryInterface;
use App\Core\Entity\Customer;
use App\Core\Migration\TransferStrategy;
use App\Tests\UnitBase;

class TransferStrategyTest extends UnitBase
{
    public function testTransferEntitiesCount()
    {
        $entities = self::createCustomerEntitiesStorage();
        $destConnector = new CustomerConnector();
        $transferStrategy = new TransferStrategy($destConnector);

        set_time_limit(5);
        $transferStrategy->transfer($entities);

        $this->assertEquals(
            9,
            count($destConnector->getRepository()->fetch(0, 100))
        );

    }

    public function testTransferEntitiesValues()
    {
        $entities = self::createCustomerEntitiesStorage();
        $destConnector = new CustomerConnector();
        $transferStrategy = new TransferStrategy($destConnector);

        set_time_limit(5);
        $transferStrategy->transfer($entities);

        $this->assertEquals(1, $destConnector->getRepository()->fetch(0, 1)[0]['id']);
        $this->assertEquals(4, $destConnector->getRepository()->fetch(3, 4)[0]['id']);
    }

}