<?php declare(strict_types=1);

namespace App\Connector\Woocommerce\ConnectorBuilder;

use App\Connector\Woocommerce\Mapper\OrderMapper;
use App\Connector\Woocommerce\Repository\OrderRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderConnectorBuilder extends ConnectorBuilder
{

    public function createRepository(
        HttpClientInterface $client,
        string $url,
        string $key,
        string $secret,
    ): void
    {
        $this->connector->setRepository(
            new OrderRepository(
                $client,
                $url,
                $key,
                $secret
            )
        );
    }

    public function createMapper(): void
    {
        $this->connector->setMapper(new OrderMapper());
    }
}