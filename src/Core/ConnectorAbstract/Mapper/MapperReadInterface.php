<?php

namespace App\Core\ConnectorAbstract\Mapper;

use App\Core\Entity\EntityInterface;

interface MapperReadInterface
{
    public function fromState(array $state): EntityInterface;
}