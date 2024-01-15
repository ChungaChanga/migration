<?php

namespace App\Connector\Magento\Repository;


use App\Event\EntitiesCreateAfterEvent;
use App\Contract\Connector\Repository\RepositoryWriteInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerRepository extends AbstractRepository
{
    public function create(array $entitiesState): array
    {
        return [];//todo
    }

    public function createOne(array $entityState): array
    {
        $response = $this->client->request(
            'POST',
            $this->url,
            [
                'json' => $entityState,
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