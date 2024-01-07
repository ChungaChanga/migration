<?php

namespace App\Migration;

use InvalidArgumentException;

class MigrationState
{
    public function __construct(
        private string $name,
        private int $startBatchNumber,
        private int $batchSize,
        private bool $isNeedWaiting = true,
        private int $jumpSize = 0,
        private int $delaySeconds = 0

    )
    {
        if ($startBatchNumber < 0) {
            throw new InvalidArgumentException('Start Batch Number can not be a negative number');
        }
        if ($jumpSize < 0) {
            throw new InvalidArgumentException('Jump Size can not be a negative number');
        }
        if ($delaySeconds < 0) {
            throw new InvalidArgumentException('Delay Seconds can not be a negative number');
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getStartBatchNumber(): int
    {
        return $this->startBatchNumber;
    }

    public function setStartBatchNumber(int $startBatchNumber): void
    {
        $this->startBatchNumber = $startBatchNumber;
    }

    public function getBatchSize(): int
    {
        return $this->batchSize;
    }

    public function setBatchSize(int $batchSize): void
    {
        $this->batchSize = $batchSize;
    }

    public function getIsNeedWaiting(): bool
    {
        return $this->isNeedWaiting;
    }

    public function setIsNeedWaiting(bool $isNeedWaiting): void
    {
        $this->isNeedWaiting = $isNeedWaiting;
    }

    public function getJumpSize(): int
    {
        return $this->jumpSize;
    }

    public function setJumpSize(int $jumpSize): void
    {
        $this->jumpSize = $jumpSize;
    }

    public function getDelaySeconds(): int
    {
        return $this->delaySeconds;
    }

    public function setDelaySeconds(int $delaySeconds): void
    {
        $this->delaySeconds = $delaySeconds;
    }
}