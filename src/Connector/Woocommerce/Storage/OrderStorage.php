<?php

namespace App\Connector\Woocommerce\Storage;

class OrderStorage extends AbstractStorage
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
        return $result['orders'];
    }
}