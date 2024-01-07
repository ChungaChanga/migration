<?php

namespace App\Connector;

use Chungachanga\AbstractMigration\Connector\ConnectorFactoryWriteInterface;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Doctrine\Common\Collections\Collection;

class ConnectorWriteType
{
    private RepositoryWriteInterface $repository;
    private MapperWriteInterface $mapper;
    public function __construct(ConnectorFactoryWriteInterface $factory)
    {
        $this->repository = $factory->createRepository();
        $this->mapper = $factory->createMapper();
    }

    public function create(Collection $entities): void
    {
        $entitiesState = [];
        foreach ($entities as $entity) {
            $entitiesState[] = $this->mapper->getState($entity);
        }
        $this->repository->create($entitiesState);
    }
}