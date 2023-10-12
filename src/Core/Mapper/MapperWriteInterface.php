<?php

namespace App\Core\Mapper;

use App\Core\Entity\EntityInterface;

interface MapperWriteInterface
{
    public function getState(EntityInterface $entity): array;
}