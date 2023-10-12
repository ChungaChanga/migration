<?php

namespace App\ConnectorFactory;

use App\ConnectorInterface\Repository\RepositoryReadInterface;
use App\ConnectorFactory\Read\Mapper;
use App\Mapper\MapperReadInterface;

interface FactoryReadInterface
{
    public function createRepository(): RepositoryReadInterface;
    public function createMapper(): MapperReadInterface;
}