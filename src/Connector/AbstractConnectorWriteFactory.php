<?php

namespace App\Connector;

use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;

abstract class AbstractConnectorWriteFactory
{
    abstract public function createRepository(): RepositoryWriteInterface;
    abstract public function createMapper(): MapperWriteInterface;
    abstract public function createConnector(): ConnectorWriteType;
}