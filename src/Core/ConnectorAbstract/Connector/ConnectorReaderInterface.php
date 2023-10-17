<?php

namespace App\Core\ConnectorAbstract\Connector;


use App\Core\ConnectorAbstract\Mapper\MapperReadInterface;
use App\Core\ConnectorAbstract\Repository\RepositoryReadInterface;

interface ConnectorReaderInterface
{
    public function getRepository(): RepositoryReadInterface;
    public function getMapper(): MapperReadInterface;
}