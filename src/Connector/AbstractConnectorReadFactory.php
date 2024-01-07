<?php

namespace App\Connector;

use App\Iterator\ConnectorIterator;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryReadInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;

abstract class AbstractConnectorReadFactory implements ConnectorFactoryReadInterface
{
    public function createIterator(
        int $startPage,
        int $pageSize,
        bool $isNeedWaitingFullPage,
        bool $isAllowPartialResult,
        int $delaySeconds
    ): \Iterator
    {
        return new ConnectorIterator(
            $this->createRepository(),
            $this->createMapper(),
            $startPage,
            $pageSize,
            $isNeedWaitingFullPage,
            $isAllowPartialResult,
            $delaySeconds
        );
    }
}