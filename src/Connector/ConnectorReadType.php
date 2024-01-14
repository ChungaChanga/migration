<?php

namespace App\Connector;

use App\Null\MapperReadNull;
use App\Null\RepositoryReadNull;
use Chungachanga\AbstractMigration\Connector\ConnectorReadInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;

class ConnectorReadType implements ConnectorReadInterface
{
    protected RepositoryReadInterface $repository;
    protected MapperReadInterface $mapper;
    protected \Iterator $iterator;

    public function __construct()
    {
        $this->repository = new RepositoryReadNull();
        $this->mapper = new MapperReadNull();
    }

    public function getRepository(): RepositoryReadInterface
    {
        return $this->repository;
    }

    public function setRepository(RepositoryReadInterface $repository): void
    {
        $this->repository = $repository;
    }

    public function getMapper(): MapperReadInterface
    {
        return $this->mapper;
    }

    public function setMapper(MapperReadInterface $mapper): void
    {
        $this->mapper = $mapper;
    }

    public function getIterator(): \Iterator
    {
        return $this->iterator;
    }

    public function setIterator(\Iterator $iterator): void
    {
        $this->iterator = $iterator;
    }
}