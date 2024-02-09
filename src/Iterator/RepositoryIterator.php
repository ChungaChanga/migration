<?php

namespace App\Iterator;

use App\Contract\Connector\Mapper\MapperReadInterface;
use App\Contract\Connector\Repository\StorageReadInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Iterator;
use InvalidArgumentException;

class RepositoryIterator implements Iterator
{
    private int $currentPage;
    private bool $isNeedRepeatIteration = false;
    private bool $isNeedBreak = false;

    public function __construct(
        private StorageReadInterface $repository,
        private int                  $startPage = 1,
        private int                  $pageSize = 10,
        private bool                 $isNeedWaitingFullPage = false,
        private bool                 $isAllowPartialResult = false,
        private int                  $delaySeconds = 0
    )
    {
        if (true === $isNeedWaitingFullPage && true === $isAllowPartialResult) {
            throw new InvalidArgumentException('Prevent duplication. Only 1 argument can be true');
        }
        if ($startPage < 1) {
            throw new InvalidArgumentException('Start Page can not be less than 1');
        }
        $this->currentPage = $this->startPage;
    }

    public function current(): ArrayCollection
    {
        $fetchResult = $this->repository->fetchPage(
            $this->currentPage,
            $this->pageSize
        );

        if ($this->isPartialResult($fetchResult)) {
            $this->handleRepeatIterationRule();
            $this->handleBreakRule();
            $fetchResult = $this->handleReturnPartialResultRule($fetchResult);
        }

        return new ArrayCollection($fetchResult);
    }

    public function next(): void
    {
        if ($this->delaySeconds > 0) {
            sleep($this->delaySeconds);
        }
        if ($this->isNeedRepeatIteration) {
            $this->isNeedRepeatIteration = false;
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

    private function handleRepeatIterationRule(): void
    {
        if (true === $this->isNeedWaitingFullPage) {
            $this->isNeedRepeatIteration = true;
        }
    }
    private function handleReturnPartialResultRule($fetchResult): array
    {
        if (false === $this->isAllowPartialResult) {
            return [];//waiting for the full page
        }
        return $fetchResult;
    }
    private function handleBreakRule(): void
    {
        if (false === $this->isNeedWaitingFullPage) {
            $this->isNeedBreak = true;
        }
    }
}