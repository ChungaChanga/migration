<?php

namespace App\Connector\Magento\Factory;

use App\Connector\Magento\Mapper\CustomerMapper;
use App\Connector\Magento\Repository\CustomerRepository;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryWriteInterface;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class CustomerConnectorFactory extends ConnectorFactory
{
    public function createRepository(): RepositoryWriteInterface
    {
        return new CustomerRepository(
            $this->client,
            $this->eventDispatcher,
            $this->repositoryUrl,
            $this->repositoryKey,
            $this->repositorySecret
        );
    }

    public function createMapper(): MapperWriteInterface
    {
        return new CustomerMapper();
    }
}