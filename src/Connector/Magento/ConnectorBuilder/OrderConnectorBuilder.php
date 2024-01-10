<?php

namespace App\Connector\Magento\ConnectorBuilder;

use App\Connector\Magento\Mapper\CustomerMapper;
use App\Connector\Magento\Mapper\OrderMapper;
use App\Connector\Magento\Repository\CustomerRepository;
use App\Connector\Magento\Repository\OrderRepository;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryReadInterface;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryWriteInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderConnectorBuilder extends ConnectorBuilder
{
    public function createRepository(
        HttpClientInterface $client,
        string $url,
        string $key,
        string $secret,
    ): RepositoryWriteInterface
    {
        return new OrderRepository(
            $client,
            $url,
            $key,
            $secret
        );
    }

    public function createMapper(): MapperWriteInterface
    {
        return new OrderMapper();
    }
}