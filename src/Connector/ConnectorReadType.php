<?php

namespace App\Connector;

use App\Iterator\ConnectorIterator;
use App\Contract\Connector\Mapper\MapperReadInterface;
use App\Contract\Connector\Repository\RepositoryReadInterface;

class ConnectorReadType
{
    private \Iterator $iterator;

    public function __construct(
        private RepositoryReadInterface $repository,
        private MapperReadInterface $mapper,
    )
    {
        $this->setIterator($this->createIterator(1));
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

    public function createIterator(
        int $startPage,
        int $pageSize = 10,
        bool $isNeedWaitingFullPage = false,
        bool $isAllowPartialResult = true,
        int $delaySeconds = 0
    ): \Iterator
    {
        if ($startPage < 1) {
            throw new \InvalidArgumentException('Start page is must be more than 0');
        }
        return new ConnectorIterator(
            $this->getRepository(),
            $this->getMapper(),
            $startPage,
            $pageSize,
            $isNeedWaitingFullPage,
            $isAllowPartialResult,
            $delaySeconds
        );
    }
}