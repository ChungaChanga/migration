<?php

namespace App\Mapper;

use App\Core\Entity\EntityInterface;

interface MapperWriteInterface
{
    public function getState(EntityInterface $entity): array;
}