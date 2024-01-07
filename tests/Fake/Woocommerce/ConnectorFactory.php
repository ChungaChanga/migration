<?php

namespace App\Tests\Fake\Woocommerce;

use App\Connector\Woocommerce\Factory\CustomerConnectorFactory;
use Chungachanga\AbstractMigration\Repository\RepositoryFullInterface;

class ConnectorFactory extends CustomerConnectorFactory
{
    public function createRepository(): RepositoryFullInterface
    {
        return new CustomerRepositoryStub();
    }
}