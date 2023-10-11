<?php

namespace App\Iterator;

use App\Repository\Interface\RepositoryReadInterface;
use Iterator;
class AwaitingIterator implements Iterator
{
    private int $position = 0;
    private int $currentRowNumber;
    private array $currentResult;

    public function __construct(
        private RepositoryReadInterface $repository,
        private int                     $batchSize,
        private int                     $firstRowNumber = 0,
    )
    {
        $this->currentRowNumber = $firstRowNumber;
    }

    public function current(): mixed
    {
        $this->setCurrentResult($this->repository->fetch(
            $this->currentRowNumber,
            $this->currentRowNumber + $this->batchSize
        ));
        return $this->getCurrentResult();
    }

    public function next(): void
    {
        if ($this->isPartialResult($this->getCurrentResult())) {
            $this->currentRowNumber += count($this->getCurrentResult());
        } else {
            $this->currentRowNumber += $this->batchSize;
            ++$this->position;
        }
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return true;
    }

    public function rewind(): void
    {
        $this->currentRowNumber = $this->firstRowNumber;
        $this->position = 0;
    }

    private function isPartialResult(array $result): bool
    {
        if (count($result) < $this->batchSize) {
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