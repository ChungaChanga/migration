<?php

namespace App\Core\ConnectorFactory;

use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use App\Core\Mapper\MapperReadInterface;

interface FactoryReadInterface
{
    public function createRepository(): RepositoryReadInterface;
    public function createMapper(): MapperReadInterface;
}