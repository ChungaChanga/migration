<?php

namespace App\Connector\Memory\Repository;

use App\Core\ConnectorAbstract\Repository\RepositoryReadAbstract;
use App\Core\ConnectorInterface\Repository\RepositoryInterface;

class CustomerRepository extends RepositoryReadAbstract implements RepositoryInterface
{
    private array $entities = [];

    public function create(array $entities)
    {
        $this->entities = array_merge($this->entities, $entities);
    }

    public function fetch(int $start, int $end): array
    {
        return array_slice($this->entities, $start, $end - $start);
    }

    public function fetchPage(int $page, int $pageSize): array
    {
        return array_slice($this->entities, ($page - 1) * $pageSize, $pageSize);
    }
}