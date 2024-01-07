<?php

namespace App\Connector\Woocommerce\Factory;

use Chungachanga\AbstractMigration\Connector\ConnectorFactoryReadInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;

class OrderConnectorFactory implements ConnectorFactoryReadInterface
{
    public function createRepository(): RepositoryReadInterface
    {
        // TODO: Implement createRepository() method.
    }

    public function createMapper(): MapperReadInterface
    {
        // TODO: Implement createMapper() method.
    }

}