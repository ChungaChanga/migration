<?php

namespace App\ConnectorFactory;

use App\ConnectorInterface\Repository\RepositoryWriteInterface;
use App\Mapper\MapperWriteInterface;

interface FactoryWriteInterface
{
    public function createRepository(): RepositoryWriteInterface;
    public function createMapper(): MapperWriteInterface;
}