<?php

namespace App\Connection;

use App\Migration\MigrationType;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryReadInterface;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryWriteInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ConnectionFactory
{
    public function __construct(
        private MigrationType $entityType
    )
    {
    }
    //fixme config?
    public function createSourceConnectorFactory(
         HttpClientInterface $client,
         string $repositoryUrl,
         string $repositoryKey,
         string $repositorySecret,
    ): ConnectorFactoryReadInterface
    {
        if (MigrationType::Customers === $this->entityType) {
            return new WooCustomerConnectorFactory($client, $repositoryUrl, $repositoryKey, $repositorySecret);
        } elseif (MigrationType::Orders === $this->entityType) {
            return new WooOrderConnectorFactory($client, $repositoryUrl, $repositoryKey, $repositorySecret);
        }
    }

    public function createDestinationConnectorFactory(
        HttpClientInterface $client,
        string $repositoryUrl,
        string $repositoryKey,
        string $repositorySecret,
    ): ConnectorFactoryWriteInterface
    {
        if (MigrationType::Customers === $this->entityType) {
            return new MagentoCustomerConnectorFactory($client, $repositoryUrl, $repositoryKey, $repositorySecret);
        } elseif (MigrationType::Orders === $this->entityType) {
            return new MagentoOrderConnectorFactory($client, $repositoryUrl, $repositoryKey, $repositorySecret);
        }
    }
}