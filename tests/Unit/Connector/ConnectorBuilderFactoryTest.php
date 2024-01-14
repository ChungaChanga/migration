<?php

namespace App\Tests\Unit\Connector;

use App\Connector\ConnectorBuilderFactory;
use App\Connector\Woocommerce\ConnectorBuilder\CustomerConnectorBuilder;
use App\Connector\Woocommerce\ConnectorBuilder\OrderConnectorBuilder;
use App\Migration\MigrationType;
use App\Tests\TestBase;
use Chungachanga\AbstractMigration\Connector\ConnectorBuilderReadInterface;
use Chungachanga\AbstractMigration\Connector\ConnectorBuilderWriteInterface;

class ConnectorBuilderFactoryTest extends TestBase
{
    /**
     * @dataProvider createConnectorBuilderProvider
     * @param MigrationType $entityType
     * @param string $sourceConnectorBuilder
     * @param string $destConnectorBuilder
     * @return void
     */
    public function testCreateConnectorBuilder(
        MigrationType $entityType,
        string $sourceConnectorBuilder,
        string $destConnectorBuilder,
    )
    {
        $factory = new ConnectorBuilderFactory($entityType);

        $this->assertInstanceOf($sourceConnectorBuilder, $factory->createSourceConnectorBuilder());
        $this->assertInstanceOf($destConnectorBuilder, $factory->createDestinationConnectorBuilder());
    }

    public function createConnectorBuilderProvider()
    {
        return [
            MigrationType::Customers->value => [
                MigrationType::Customers,
                'source' => CustomerConnectorBuilder::class,
                'dest' => \App\Connector\Magento\ConnectorBuilder\CustomerConnectorBuilder::class,
            ],
            MigrationType::Orders->value => [
                MigrationType::Orders,
                'source' => OrderConnectorBuilder::class,
                'dest' => \App\Connector\Magento\ConnectorBuilder\OrderConnectorBuilder::class,
            ],
        ];
    }
}