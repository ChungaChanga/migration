<?php

namespace App\Connector\Magento\Repository;


use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerRepository implements RepositoryWriteInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $url,
    )
    {
    }
    public function create(array $entitiesData): string
    {
        foreach ($entitiesData as $data) {
            $destId = $this->createOne($data);
        }
        return 'ok';//fixme
    }

    public function createOne($data): string
    {
        $response = $this->client->request(
            'POST',
            $this->url,
            [
                'json' => [
                    'customer' => $data['entity'],
                    'password' => $data['password']
                ],
            ]
        );
        if (200 !== $response->getStatusCode()) {//fixme
            throw new \Exception(sprintf(
                'Wrong status code: %d. Message: %s',
                $response->getStatusCode(),
                $response->getContent()
            ));
        }
        $result = $response->toArray();
        return $result['id'];
    }
}