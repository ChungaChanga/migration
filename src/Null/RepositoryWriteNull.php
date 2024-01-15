<?php

namespace App\Null;

use App\Contract\Connector\Repository\RepositoryWriteInterface;

class RepositoryWriteNull implements RepositoryWriteInterface
{
    public function create(array $entitiesState): array
    {
        return [];
    }

    public function createOne(array $entityState): array
    {
        return [];
    }
}