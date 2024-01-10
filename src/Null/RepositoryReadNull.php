<?php

namespace App\Null;

use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;

class RepositoryReadNull implements RepositoryReadInterface
{
    public function fetchPage(int $page, int $pageSize): array
    {
        return [];
    }
}