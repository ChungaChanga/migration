<?php

namespace App\Core\ConnectorFactory;

use App\Core\ConnectorInterface\Repository\RepositoryInterface;
use App\Core\Mapper\MapperInterface;

interface FactoryInterface extends FactoryReaderInterface, FactoryWriterInterface
{
    public function createRepository(): RepositoryInterface;
    public function createMapper(): MapperInterface;
}