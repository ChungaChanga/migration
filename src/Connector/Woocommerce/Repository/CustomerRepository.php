<?php

namespace App\Connector\Woocommerce\Repository;


use App\Iterator\AwaitingIteratorWrapper;
use App\Connector\RepositoryReadAbstract;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerRepository extends AbstractRepository
{
    public function fetchPage(int $page, int $pageSize): array
    {
        $response = $this->client->request(
            'GET',
            $this->url,
            [
                'auth_basic' => [$this->key, $this->secret],
                'query' => [
                    'page' => $page,
                    'per_page' => $pageSize,
                ],
            ]
        );
        $result = $response->toArray();
        if (empty($result)) {
            return [];
        }
        return $result['customers'];
    }
}