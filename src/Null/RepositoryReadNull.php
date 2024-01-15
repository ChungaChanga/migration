<?php

namespace App\Null;

use App\Contract\Connector\Repository\RepositoryReadInterface;

class RepositoryReadNull implements RepositoryReadInterface
{
    public function fetchPage(int $page, int $pageSize): array
    {
        return [];
    }
}