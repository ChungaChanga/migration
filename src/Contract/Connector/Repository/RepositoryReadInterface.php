<?php

namespace App\Contract\Connector\Repository;

interface RepositoryReadInterface
{
    public function fetchPage(int $page, int $pageSize): array;
}