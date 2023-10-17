<?php

namespace App\Core\ConnectorInterface\Mapper;

use App\Core\Entity\EntityInterface;

interface MapperReadInterface
{
    public function fromState(array $state): EntityInterface;
}