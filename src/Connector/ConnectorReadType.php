<?php

namespace App\Connector;

use App\Iterator\ConnectorIterator;
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

    public function getIterator(int $startPage, int $pageSize): \Iterator
    {
        $iterator = new ConnectorIterator($this->repository, $startPage, $pageSize);
        $iterator = new M
    }
}