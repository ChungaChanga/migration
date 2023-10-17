<?php

namespace App\Core\ConnectorAbstract\Connector;

use App\Core\ConnectorInterface\Mapper\MapperInterface;
use App\Core\ConnectorInterface\Repository\RepositoryInterface;

interface ConnectorInterface extends ConnectorReaderInterface, ConnectorWriterInterface
{
    public function getRepository(): RepositoryInterface;
    public function getMapper(): MapperInterface;
}