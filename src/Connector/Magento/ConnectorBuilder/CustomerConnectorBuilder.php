<?php

namespace App\Connector\Magento\ConnectorBuilder;

use App\Connector\Magento\Mapper\CustomerMapper;
use App\Connector\Magento\Repository\CustomerRepository;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryWriteInterface;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerConnectorBuilder extends ConnectorBuilder
{
    public function createRepository(
        HttpClientInterface $client,
        string $url,
        string $key,
        string $secret,
    ): void
    {
        $this->connector->setRepository(
            new CustomerRepository(
                $client,
                $url,
                $key,
                $secret
            )
        );
    }

    public function createMapper(): void
    {
        $this->connector->setMapper(new CustomerMapper());
    }
}