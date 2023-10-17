<?php

namespace App\Core\Iterator;

use App\Core\ConnectorAbstract\Repository\RepositoryReadInterface;
use Iterator;
use InvalidArgumentException;

class AwaitingPageIterator implements Iterator
{
    private int $currentPage;
    private array $currentResult;


    public function __construct(
        private RepositoryReadInterface $repository,
        private int $startPage = 1,
        private int $pageSize = 10,
        private int $jumpSize = 0,
    )
    {
        if ($startPage < 1) {
            throw new InvalidArgumentException('Start Page can not be less than 1');
        }
        $this->currentPage = $this->startPage;
    }

    public function current(): mixed
    {
        $result = $this->repository->fetchPage(
            $this->currentPage,
            $this->pageSize
        );

        if ($this->isPartialResult($result)) {
            $this->setCurrentResult([]);//waiting for the full page
        } else {
            $this->setCurrentResult($result);
        }

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