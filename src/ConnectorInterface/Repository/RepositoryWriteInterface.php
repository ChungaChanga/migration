<?php

namespace App\ConnectorInterface\Repository;

interface RepositoryWriteInterface
{
    public function create(array $entities);
}