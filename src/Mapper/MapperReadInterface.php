<?php

namespace App\Mapper;

use App\Core\Entity\EntityInterface;

interface MapperReadInterface
{
    public function fromState(array $state): EntityInterface;
}