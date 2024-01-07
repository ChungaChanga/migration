<?php

namespace App\Connector;

use App\Iterator\AwaitingIteratorWrapper;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;

abstract class RepositoryReadAbstract implements RepositoryReadInterface
{
    public function createAwaitingPageIterator(
        int $page,
        int $pageSize = 10,
        int $jumpSize = 0,
    ): AwaitingIteratorWrapper
    {
        return new AwaitingIteratorWrapper($this, $page, $pageSize, $jumpSize);
    }

    protected function validatePage(int $page): void
    {
        if ($page < 1) {
            throw new \InvalidArgumentException('Page must be more than 1');
        }
    }
}