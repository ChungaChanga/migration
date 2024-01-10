<?php

namespace App\Null;

use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;

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