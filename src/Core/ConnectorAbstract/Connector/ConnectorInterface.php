<?php

namespace App\Core\ConnectorAbstract\Connector;


use App\Core\ConnectorAbstract\Mapper\MapperInterface;
use App\Core\ConnectorAbstract\Repository\RepositoryInterface;

interface ConnectorInterface extends ConnectorReaderInterface, ConnectorWriterInterface
{
    public function getRepository(): RepositoryInterface;
    public function getMapper(): MapperInterface;
}