<?php

namespace App\Core\ConnectorAbstract\Repository;

interface RepositoryWriteInterface
{
    public function create(array $entities);
}