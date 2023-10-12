<?php

namespace App\Core\ConnectorFactory;

use App\Core\ConnectorInterface\Repository\RepositoryWriteInterface;
use App\Core\Mapper\MapperWriteInterface;

interface FactoryWriteInterface
{
    public function createRepository(): RepositoryWriteInterface;
    public function createMapper(): MapperWriteInterface;
}