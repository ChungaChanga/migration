<?php

namespace App\Migration;

use InvalidArgumentException;
class MigrationState
{
    public function __construct(
        private string $name,
        private int $startBatchNumber,
        private int $batchSize,
        private int $endBatchNumber = PHP_INT_MAX,
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
        if ($startBatchNumber > $endBatchNumber) {
            throw new InvalidArgumentException('Start Batch Number can not be more than End Batch Number');
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

    public function getEndBatchNumber(): int
    {
        return $this->endBatchNumber;
    }

    public function setEndBatchNumber(int $endBatchNumber): void
    {
        $this->endBatchNumber = $endBatchNumber;
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