<?php

namespace App\Core\ConnectorInterface\Connector;

use App\Core\ConnectorInterface\Repository\RepositoryInterface;
use App\Core\Mapper\MapperInterface;

interface ConnectorInterface extends ConnectorReaderInterface, ConnectorWriterInterface
{
    public function getRepository(): RepositoryInterface;
    public function getMapper(): MapperInterface;
}