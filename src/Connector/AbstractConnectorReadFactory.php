<?php declare(strict_types=1);

namespace App\Connector;

use App\Iterator\ConnectorIterator;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryReadInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;

abstract class AbstractConnectorReadFactory implements ConnectorFactoryReadInterface
{
    abstract public function createRepository(): RepositoryReadInterface;
    abstract public function createMapper(): MapperReadInterface;
    abstract public function createConnector(): ConnectorReadType;
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