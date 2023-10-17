<?php

namespace App\Core\ConnectorAbstract\Mapper;

use App\Core\Entity\EntityInterface;

interface MapperWriteInterface
{
    public function getState(EntityInterface $entity): array;
}