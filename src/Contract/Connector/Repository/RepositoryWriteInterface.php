<?php

namespace App\Contract\Connector\Repository;

interface RepositoryWriteInterface
{
    public function createOne(array $entityState): array;
}