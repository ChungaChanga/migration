<?php

namespace App\Core\ConnectorInterface\Repository;

interface RepositoryWriteInterface
{
    public function create(array $entities);
}