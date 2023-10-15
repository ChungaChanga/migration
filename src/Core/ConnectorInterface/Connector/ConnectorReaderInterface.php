<?php

namespace App\Core\ConnectorInterface\Connector;

use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use App\Core\Mapper\MapperReadInterface;

interface ConnectorReaderInterface
{
    public function createRepository(): RepositoryReadInterface;
    public function createMapper(): MapperReadInterface;
}