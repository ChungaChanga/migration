<?php

namespace App\Core\ConnectorInterface\Connector;

use App\Core\ConnectorInterface\Repository\RepositoryWriteInterface;
use App\Core\Mapper\MapperWriteInterface;

interface ConnectorWriterInterface
{
    public function getRepository(): RepositoryWriteInterface;
    public function getMapper(): MapperWriteInterface;
}