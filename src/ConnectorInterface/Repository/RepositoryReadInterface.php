<?php

namespace App\ConnectorInterface\Repository;

interface RepositoryReadInterface
{
    public function fetch(int $start, int $end): array;
}