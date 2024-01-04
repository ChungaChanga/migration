<?php

namespace App\Tests\Mock\Woocommerce\Connector;

use App\Connector\Woocommerce\Connector\CustomerConnector;
use App\Tests\Mock\Woocommerce\Repository\StubCustomerRepository;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MockCustomerConnector extends CustomerConnector
{
    public function setRepository(RepositoryReadInterface $repository): RepositoryReadInterface
    {
    }
}