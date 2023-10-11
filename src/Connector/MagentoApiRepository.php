<?php

namespace App\Connector;

use App\Connector\Interface\RepositoryWriteInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MagentoApiRepository implements RepositoryWriteInterface
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }
    public function createCustomers(array $customers)
    {
        $response = $this->client->request(
            'GET',
            'https://api.github.com/repos/symfony/symfony-docs'
        );

        return [$response->getStatusCode()];
    }

}