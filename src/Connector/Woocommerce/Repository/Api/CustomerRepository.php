<?php

namespace App\Connector\Woocommerce\Repository\Api;


use App\ConnectorInterface\Repository\RepositoryReadInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerRepository implements RepositoryReadInterface
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }
    public function fetch(int $start, int $end): array
    {
        $response = $this->client->request(
            'GET',
            'https://dl.loc/wc-api/v3/customers',
            [
                'auth_basic' => [$_ENV['WOOCOMMERCE_API_KEY'], $_ENV['WOOCOMMERCE_API_SECRET']],
            ]
        );
        return $response->toArray()['customers'];
    }
}