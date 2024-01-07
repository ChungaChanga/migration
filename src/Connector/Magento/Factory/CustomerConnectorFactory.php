<?php

namespace App\Connector\Magento\Factory;

use App\Connector\Magento\Mapper\CustomerMapper;
use App\Connector\Magento\Repository\CustomerRepository;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryWriteInterface;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerConnectorFactory implements ConnectorFactoryWriteInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $repositoryUrl,
        private string $repositoryKey,
        private string $repositorySecret,
    )
    {
    }
    public function createRepository(): RepositoryWriteInterface
    {
        return new CustomerRepository(
            $this->client,
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