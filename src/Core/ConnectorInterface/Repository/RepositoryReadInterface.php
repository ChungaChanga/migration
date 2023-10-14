<?php

namespace App\Core\ConnectorInterface\Repository;

use App\Core\Iterator\AwaitingIterator;
use App\Core\Iterator\AwaitingPageIterator;

interface RepositoryReadInterface
{
    public function fetch(int $start, int $end): array;
    public function fetchPage(int $page, int $pageSize): array;
    public function createAwaitingPageIterator(int $page, int $pageSize): AwaitingPageIterator;
}