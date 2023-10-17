<?php

namespace App\Tests\Functional;

use App\Connector\Memory\Connector\CustomerConnector as MemoryCustomerConnector;
use App\Connector\Woocommerce\Connector\CustomerConnector as WoocommerceCustomerConnector;
use App\Core\Connection\Connection;
use App\Core\Migration\TransferStrategy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BatchStrategyTest extends KernelTestCase
{
    public function testTransferEntitiesCount()
    {
        self::bootKernel();
        $container = self::getContainer();
        $client = $container->get(HttpClientInterface::class);

        $connection = new Connection(
            new WoocommerceCustomerConnector($client),
            new MemoryCustomerConnector()
        );

        $this->assertEquals(
            0,
            count($connection->getDestinationConnector()->getRepository()->fetch(0, 100))
        );

        $transferStrategy = new TransferStrategy(
            $connection,
            1,
            9,
            1,
        );

        set_time_limit(5);
        $transferStrategy->start();

        $this->assertEquals(
            9,
            count($connection->getDestinationConnector()->getRepository()->fetch(0, 100))
        );

    }

}