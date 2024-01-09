<?php

namespace App\Connector\Magento\Factory;

use App\Connector\ConnectorWriteType;
use App\Event\EntitiesCreateAfterEvent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AbstractConnectorFactory extends ConnectorWriteType
{
    public function __construct(
        protected HttpClientInterface $client,
        protected EventDispatcher $eventDispatcher,
        protected string $repositoryUrl,
        protected string $repositoryKey,
        protected string $repositorySecret,
    )
    {
    }

    public function create(Collection $entities): void
    {
        foreach ($entities as $entity) {
            $entityState = $this->mapper->getState($entity);
            $result = $this->repository->createOne($entityState);
            $event = new EntitiesCreateAfterEvent(new ArrayCollection([$entity]), $result);
            $this->eventDispatcher->dispatch($event);
        }
    }
}