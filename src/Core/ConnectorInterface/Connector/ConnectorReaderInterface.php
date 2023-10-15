<?php

namespace App\Core\ConnectorInterface\Connector;

use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use App\Core\Mapper\MapperReadInterface;

interface ConnectorReaderInterface
{
    public function getRepository(): RepositoryReadInterface;
    public function getMapper(): MapperReadInterface;
}