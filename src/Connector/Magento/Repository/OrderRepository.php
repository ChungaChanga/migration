<?php

namespace App\Connector\Magento\Repository;

use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;

class OrderRepository implements RepositoryWriteInterface
{
    public function create(array $entities): array
    {
        return [];
    }
}