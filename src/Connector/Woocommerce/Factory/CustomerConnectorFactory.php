<?php

namespace App\Connector\Woocommerce\Factory;

use App\Connector\AbstractConnectorReadFactory;
use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryReadInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerConnectorFactory extends AbstractConnectorReadFactory implements ConnectorFactoryReadInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $repositoryUrl,
        private string $repositoryKey,
        private string $repositorySecret,
    )
    {
    }
    public function createRepository(): RepositoryReadInterface
    {
        return new CustomerRepository(
            $this->client,
            $this->repositoryUrl,
            $this->repositoryKey,
            $this->repositorySecret
        );
    }

    public function createMapper(): MapperReadInterface
    {
        return new CustomerMapper();
    }
}