<?php declare(strict_types=1);

namespace App\Connector\Woocommerce\ConnectorBuilder;

use App\Connector\ConnectorReadType;
use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
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