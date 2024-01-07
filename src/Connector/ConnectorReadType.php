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
        int $pageSize
    )
    {
        $this->iterator = $factory->createIterator($startPage, $pageSize);
    }

    public function getIterator(): \Iterator
    {
        return $this->iterator;
    }
}