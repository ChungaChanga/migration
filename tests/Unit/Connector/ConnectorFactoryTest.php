<?php

namespace App\Tests\Unit\Connector;

use App\Connector\ConnectorFactory;
use App\Connector\ConnectorReadType;
use App\Connector\ConnectorWriteType;
use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use App\Connector\Woocommerce\Repository\OrderRepository;
use App\Migration\MigrationType;
use App\Tests\TestBase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpClient\MockHttpClient;

class ConnectorFactoryTest extends TestBase
{
    /**
     * @dataProvider createConnectorProvider
     * @param MigrationType $entityType
     * @param string $sourceConnectorBuilder
     * @param string $destConnectorBuilder
     * @return void
     */
    public function testCreateConnectorBuilder(
        MigrationType $entityType,
        array $source,
        array $dest,
    )
    {
        $httpClientMock = new MockHttpClient();
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $paramsMock = $this->createMock(ContainerBagInterface::class);
        $factory = new ConnectorFactory(
            $entityType,
            $httpClientMock,
            $entityManagerMock,
            $paramsMock
        );

        $sourceConnector = $factory->createSourceConnector();
        $this->assertInstanceOf($source['connector'], $sourceConnector);
        $this->assertInstanceOf($source['repository'], $sourceConnector->getRepository());
        $this->assertInstanceOf($source['mapper'], $sourceConnector->getMapper());

        $destConnector = $factory->createDestinationConnector();
        $this->assertInstanceOf($dest['connector'], $destConnector);
        $this->assertInstanceOf($dest['repository'], $destConnector->getRepository());
        $this->assertInstanceOf($dest['mapper'], $destConnector->getMapper());
    }

    public function createConnectorProvider()
    {
        return [
            MigrationType::Customers->value => [
                MigrationType::Customers,
                'source' => [
                    'connector' => ConnectorReadType::class,
                    'repository' => CustomerRepository::class,
                    'mapper' => CustomerMapper::class,
                ],
                'dest' => [
                    'connector' => ConnectorWriteType::class,
                    'repository' => \App\Connector\Magento\Repository\CustomerRepository::class,
                    'mapper' => \App\Connector\Magento\Mapper\CustomerMapper::class,
                ]
            ],
            MigrationType::Orders->value => [
                MigrationType::Orders,
                'source' => [
                    'connector' => ConnectorReadType::class,
                    'repository' => OrderRepository::class,
                    'mapper' => \App\Connector\Woocommerce\Mapper\OrderMapper::class,
                ],
                'dest' => [
                    'connector' => ConnectorWriteType::class,
                    'repository' => \App\Connector\Magento\Repository\OrderRepository::class,
                    'mapper' => \App\Connector\Magento\Mapper\OrderMapper::class,
                ]
            ],
        ];
    }
}