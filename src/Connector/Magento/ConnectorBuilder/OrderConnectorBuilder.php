<?php

namespace App\Connector\Magento\ConnectorBuilder;

use App\Connector\Magento\Mapper\OrderMapper;
use App\Connector\Magento\Repository\OrderRepository;

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