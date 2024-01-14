<?php

namespace App\Connector;

use App\Connector\Magento\ConnectorBuilder\CustomerConnectorBuilder as MagentoCustomerConnectorBuilder;
use App\Connector\Magento\ConnectorBuilder\OrderConnectorBuilder as MagentoOrderConnectorBuilder;
use App\Connector\Woocommerce\ConnectorBuilder\CustomerConnectorBuilder as WooCustomerConnectorBuilder;
use App\Connector\Woocommerce\ConnectorBuilder\OrderConnectorBuilder as WooOrderConnectorBuilder;
use App\Migration\MigrationType;
use Chungachanga\AbstractMigration\Connector\ConnectorBuilderReadInterface;
use Chungachanga\AbstractMigration\Connector\ConnectorBuilderWriteInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ConnectorBuilderFactory
{
    public function __construct(
        private MigrationType $entityType
    )
    {
    }
    public function createSourceConnectorBuilder(): ConnectorBuilderReadInterface
    {
        if (MigrationType::Customers === $this->entityType) {
            return new WooCustomerConnectorBuilder();
        } elseif (MigrationType::Orders === $this->entityType) {
            return new WooOrderConnectorBuilder();
        }
    }

    public function createDestinationConnectorBuilder(): ConnectorBuilderWriteInterface
    {
        if (MigrationType::Customers === $this->entityType) {
            return new MagentoCustomerConnectorBuilder();
        } elseif (MigrationType::Orders === $this->entityType) {
            return new MagentoOrderConnectorBuilder();
        }
    }
}