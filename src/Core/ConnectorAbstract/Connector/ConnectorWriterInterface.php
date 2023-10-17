<?php

namespace App\Core\ConnectorAbstract\Connector;


use App\Core\ConnectorAbstract\Mapper\MapperWriteInterface;
use App\Core\ConnectorAbstract\Repository\RepositoryWriteInterface;

interface ConnectorWriterInterface
{
    public function getRepository(): RepositoryWriteInterface;
    public function getMapper(): MapperWriteInterface;
}