<?php

namespace App\Contract\Connector\Repository;

interface StorageWriteInterface
{
    public function createOne(array $entityState): array;
}