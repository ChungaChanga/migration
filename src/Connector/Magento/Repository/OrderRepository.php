<?php

namespace App\Connector\Magento\Repository;

use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;

class OrderRepository implements RepositoryWriteInterface
{
    public function create(array $entities): string
    {
        return (string)rand(1000, 5000);
    }
}