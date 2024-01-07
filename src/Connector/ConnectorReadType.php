<?php

namespace App\Connector;

use Chungachanga\AbstractMigration\Connector\ConnectorFactoryReadInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;

class ConnectorReadType
{
    private RepositoryReadInterface $repository;
    private MapperReadInterface $mapper;
    public function __construct(ConnectorFactoryReadInterface $factory)
    {
        $this->repository = $factory->createRepository();
        $this->mapper = $factory->createMapper();
    }

    public function getIterator(): \Iterator
    {
        // TODO: Implement getReadingIterator() method.
    }
}