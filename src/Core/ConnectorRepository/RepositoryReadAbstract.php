<?php

namespace App\Core\ConnectorRepository;

use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use App\Core\Iterator\AwaitingIterator;
use App\Core\Iterator\AwaitingPageIterator;

abstract class RepositoryReadAbstract implements RepositoryReadInterface
{
    public function createAwaitingPageIterator(
        int $startPage,
        int $pageSize = 10,
        int $jumpSize = 0,
    ): AwaitingPageIterator
    {
        return new AwaitingPageIterator($this, $startPage, $pageSize, $jumpSize);
    }
}