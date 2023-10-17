<?php

namespace App\Core\ConnectorInterface\Connector;

use App\Core\ConnectorInterface\Mapper\MapperReadInterface;
use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;

interface ConnectorReaderInterface
{
    public function getRepository(): RepositoryReadInterface;
    public function getMapper(): MapperReadInterface;
}