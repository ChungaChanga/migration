<?php

namespace App\Connector\Magento\Repository;


use App\Event\EntitiesCreateAfterEvent;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerRepository implements RepositoryWriteInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $url,
    )
    {
    }
    public function create(array $data): array
    {
        $response = $this->client->request(
            'POST',
            $this->url,
            [
                'json' => $data,
            ]
        );
        if (200 !== $response->getStatusCode()) {//fixme
            throw new \Exception(sprintf(
                'Wrong status code: %d. Message: %s',
                $response->getStatusCode(),
                $response->getContent()
            ));
        }
        return $response->toArray();
    }

}