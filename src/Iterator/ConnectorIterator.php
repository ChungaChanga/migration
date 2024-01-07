<?php

namespace App\Iterator;

use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Iterator;
use InvalidArgumentException;

class ConnectorIterator implements Iterator
{
    private int $currentPage;
    private bool $isNeedRepeatIteration = false;
    private bool $isNeedBreak = false;

    public function __construct(
        private RepositoryReadInterface $repository,
        private MapperReadInterface $mapper,
        private int $startPage = 1,
        private int $pageSize = 10,
        private bool $isNeedWaitingFullPage = false,
        private int $delaySeconds = 0
    )
    {
        if ($startPage < 1) {
            throw new InvalidArgumentException('Start Page can not be less than 1');
        }
        $this->currentPage = $this->startPage;
    }

    public function current(): ArrayCollection
    {
        //todo check memory leak
        $result = new ArrayCollection();

        $fetchResult = $this->repository->fetchPage(
            $this->currentPage,
            $this->pageSize
        );

        $this->isNeedRepeatIteration = false;
        if ($this->isPartialResult($fetchResult)) {
            if (true === $this->isNeedWaitingFullPage) {
                $fetchResult = [];//waiting for the full page
                $this->isNeedRepeatIteration = true;
            } else {
                $this->isNeedBreak = true;
            }
        }

        foreach ($fetchResult as $entityState) {
            $result->add($this->mapper->fromState($entityState));
        }

        return $result;
    }

    public function next(): void
    {
        if ($this->delaySeconds > 0) {
            sleep($this->delaySeconds);
        }
        if ($this->isNeedRepeatIteration) {
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
        return !$this->isNeedBreak;
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
}