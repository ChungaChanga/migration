<?php

namespace App\Core\Mapper;

use App\Core\Entity\EntityInterface;

interface MapperReadInterface
{
    public function fromState(array $state): EntityInterface;
}