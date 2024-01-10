<?php

namespace App\Connector\Magento\Repository;

use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;

class OrderRepository implements RepositoryWriteInterface
{
    public function create(array $entitiesState): array
    {
        return [];//todo
    }
    public function createOne(array $entityState): array
    {
        return [];//todo
    }
}