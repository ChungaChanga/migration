<?php

namespace App\Core\ConnectorFactory;

use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use App\Core\Mapper\MapperReadInterface;

interface FactoryReaderInterface
{
    public function createRepository(): RepositoryReadInterface;
    public function createMapper(): MapperReadInterface;
}