<?php

namespace App\Iterator;

use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Iterator;
use InvalidArgumentException;

class ConnectorIterator implements Iterator
{
    private int $currentPage;
    private array $currentResult;


    public function __construct(
        private RepositoryReadInterface $repository,
        private MapperReadInterface $mapper,
        private int $startPage = 1,
        private int $pageSize = 10,
    )
    {
        if ($startPage < 1) {
            throw new InvalidArgumentException('Start Page can not be less than 1');
        }
        $this->currentPage = $this->startPage;
    }

    public function current(): array
    {
        $result = $this->repository->fetchPage(
            $this->currentPage,
            $this->pageSize
        );
        if ($this->isPartialResult($result)) {
            $result = [];//waiting for the full page
        }
        $this->setCurrentResult($this->mapper->fromState($result));
        return $this->getCurrentResult();
    }

    public function next(): void
    {
        if ($this->isPartialResult($this->getCurrentResult())) {
            return;
        }
        $this->currentPage++;
    }

    public function key(): mixed
    {
        return $this->currentPage;
    }

    public function valid(): bool
    {
        return true;
    }

    public function rewind(): void
    {
        $this->currentPage = $this->startPage;
    }

    private function isPartialResult(array $result): bool
    {
        if (count($result) < $this->pageSize) {
            return true;
        }
        return false;
    }

    private function getCurrentResult(): array
    {
        return $this->currentResult;
    }

    private function setCurrentResult(array $currentResult): void
    {
        $this->currentResult = $currentResult;
    }
}