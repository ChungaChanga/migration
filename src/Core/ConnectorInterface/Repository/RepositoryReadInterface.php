<?php

namespace App\Core\ConnectorInterface\Repository;

interface RepositoryReadInterface
{
    public function fetch(int $start, int $end): array;
}