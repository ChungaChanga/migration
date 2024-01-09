<?php

namespace App\Connector;

use Chungachanga\AbstractMigration\Connector\ConnectorFactoryWriteInterface;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Doctrine\Common\Collections\Collection;

abstract class ConnectorWriteType
{
    protected RepositoryWriteInterface $repository;
    protected MapperWriteInterface $mapper;
    public function __construct(ConnectorFactoryWriteInterface $factory)
    {
        $this->repository = $factory->createRepository();
        $this->mapper = $factory->createMapper();
    }

    abstract public function create(Collection $entities): void;
}