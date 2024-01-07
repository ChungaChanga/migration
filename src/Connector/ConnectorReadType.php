<?php

namespace App\Connector;

use App\Iterator\ConnectorIterator;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryReadInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;

class ConnectorReadType
{
    private \Iterator $iterator;
    public function __construct(
        ConnectorFactoryReadInterface $factory,
        int $startPage,
        int $pageSize,
        bool $isNeedWaitingFullPage = false,
        bool $isAllowPartialResult = false,
        int $delaySeconds = 0
    )
    {
        $this->iterator = $factory->createIterator(
            $startPage,
            $pageSize,
            $isNeedWaitingFullPage,
            $isAllowPartialResult,
            $delaySeconds
        );
    }

    public function getIterator(): \Iterator
    {
        return $this->iterator;
    }
}