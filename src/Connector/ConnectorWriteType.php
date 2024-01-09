<?php

namespace App\Connector;

use Chungachanga\AbstractMigration\Connector\ConnectorFactoryWriteInterface;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Doctrine\Common\Collections\Collection;

abstract class ConnectorWriteType
{
    abstract public function create(Collection $entities): void;
}