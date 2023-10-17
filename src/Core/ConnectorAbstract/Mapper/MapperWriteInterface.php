<?php

namespace App\Core\ConnectorInterface\Mapper;

use App\Core\Entity\EntityInterface;

interface MapperWriteInterface
{
    public function getState(EntityInterface $entity): array;
}