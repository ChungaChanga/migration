<?php

namespace App\Contract\Connector\Repository;

interface StorageReadInterface
{
    public function fetchPage(int $page, int $pageSize): array;
}