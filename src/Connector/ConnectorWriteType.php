<?php declare(strict_types=1);

namespace App\Connector;

use App\Event\EntitiesCreateAfterEvent;
use App\Event\EntitiesCreateBeforeEvent;
use App\Event\EntitiesCreateErrorEvent;
use App\Null\EventDispatcherNull;
use App\Null\MapperWriteNull;
use App\Null\RepositoryWriteNull;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ConnectorWriteType
{
    protected RepositoryWriteInterface $repository;
    protected MapperWriteInterface $mapper;
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct()
    {
        $this->repository = new RepositoryWriteNull();
        $this->mapper = new MapperWriteNull();
        $this->eventDispatcher = new EventDispatcherNull();
    }

    public function create(Collection $entities): void
    {
        $currentEntitiesCollection = new ArrayCollection();
        foreach ($entities as $entity) {
            $currentEntitiesCollection->clear();
            $currentEntitiesCollection->add($entity);

            $entityState = $this->mapper->getState($entity);

            $beforeEvent = new EntitiesCreateBeforeEvent($currentEntitiesCollection) ;
            $this->eventDispatcher->dispatch($beforeEvent, EntitiesCreateBeforeEvent::NAME);
            try {
                $result = $this->repository->createOne($entityState);
                $afterEvent = new EntitiesCreateAfterEvent($currentEntitiesCollection, $result) ;
                $this->eventDispatcher->dispatch($afterEvent, EntitiesCreateAfterEvent::NAME);
            } catch (\Exception $e) {
                $event = new EntitiesCreateErrorEvent($currentEntitiesCollection, $result);
                $this->eventDispatcher->dispatch($event, EntitiesCreateErrorEvent::NAME);
            }
        }
    }

    public function getRepository(): RepositoryWriteInterface
    {
        return $this->repository;
    }

    public function setRepository(RepositoryWriteInterface $repository): void
    {
        $this->repository = $repository;
    }

    public function getMapper(): MapperWriteInterface
    {
        return $this->mapper;
    }

    public function setMapper(MapperWriteInterface $mapper): void
    {
        $this->mapper = $mapper;
    }

    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

}