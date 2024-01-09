<?php

namespace App\Connector\Magento\Connector;

use App\Connector\ConnectorWriteType;
use App\Event\EntitiesCreateAfterEvent;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryWriteInterface;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class BaseConnector extends ConnectorWriteType
{
    public function __construct(
        private RepositoryWriteInterface $repository,
        private MapperWriteInterface $mapper,
        private EventDispatcherInterface $eventDispatcher
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