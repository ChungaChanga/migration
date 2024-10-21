<?php

namespace App\Connector\Woocommerce\Storage;

class CustomerStorage extends AbstractStorage
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
                    'limit' => $pageSize,
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