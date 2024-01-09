<?php declare(strict_types=1);

namespace App\Connector\Woocommerce\Factory;

use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerConnectorFactory extends ConnectorFactory
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