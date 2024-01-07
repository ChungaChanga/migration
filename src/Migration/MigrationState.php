<?php

namespace App\Migration;

use InvalidArgumentException;

class MigrationState
{
    public function __construct(
        private string $name,
        private int    $pageSize = 10,
        private bool   $isNeedWaiting = true,
        private int    $jumpSize = 0,
        private int    $delaySeconds = 0

    )
    {
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

    public function getStartPage(): int
    {
        return $this->startPage;
    }

    public function setStartPage(int $startPage): void
    {
        $this->startPage = $startPage;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function setPageSize(int $pageSize): void
    {
        $this->pageSize = $pageSize;
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