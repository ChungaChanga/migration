<?php

namespace App\Connector\Magento\Storage;

use App\Contract\Connector\Repository\StorageWriteInterface;

class OrderStorage extends AbstractStorage
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