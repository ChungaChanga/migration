<?php

namespace App\Core\ConnectorInterface\Connector;

use App\Core\ConnectorInterface\Mapper\MapperWriteInterface;
use App\Core\ConnectorInterface\Repository\RepositoryWriteInterface;

interface ConnectorWriterInterface
{
    public function getRepository(): RepositoryWriteInterface;
    public function getMapper(): MapperWriteInterface;
}