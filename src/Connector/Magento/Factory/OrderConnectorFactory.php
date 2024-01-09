<?php

namespace App\Connector\Magento\Factory;

use Chungachanga\AbstractMigration\Connector\ConnectorFactoryReadInterface;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryWriteInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;

class OrderConnectorFactory extends ConnectorFactory
{
    public function createRepository(): RepositoryWriteInterface
    {
        // TODO: Implement createRepository() method.
    }

    public function createMapper(): MapperWriteInterface
    {
        // TODO: Implement createMapper() method.
    }

}