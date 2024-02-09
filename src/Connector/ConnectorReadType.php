<?php

namespace App\Connector;

use App\Iterator\MappingRepositoryIteratorIterator;
use App\Iterator\RepositoryIterator;
use App\Contract\Connector\Mapper\MapperReadInterface;
use App\Contract\Connector\Repository\StorageReadInterface;
use Doctrine\ORM\EntityManagerInterface;

class ConnectorReadType
{
    private \Iterator $iterator;

    public function __construct(
        private StorageReadInterface $storage,
        private MapperReadInterface  $mapper,
    )
    {
        $this->setIterator($this->createIterator());
    }

    public function getStorage(): StorageReadInterface
    {
        return $this->storage;
    }

    public function setStorage(StorageReadInterface $storage): void
    {
        $this->storage = $storage;
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

    public function createIterator(
        int $startPage = 1,
        int $pageSize = 10,
        bool $isNeedWaitingFullPage = false,
        bool $isAllowPartialResult = true,
        int $delaySeconds = 0
    ): \Iterator
    {
        if ($startPage < 1) {
            throw new \InvalidArgumentException('Start page is must be more than 0');
        }
        $repositoryIterator =  new RepositoryIterator(
            $this->getStorage(),
            $startPage,
            $pageSize,
            $isNeedWaitingFullPage,
            $isAllowPartialResult,
            $delaySeconds
        );
        return new MappingRepositoryIteratorIterator(iterator: $repositoryIterator, mapper: $this->getMapper());
    }
}