<?php

namespace App\Connector\Woocommerce\Factory;

use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use App\Core\ConnectorFactory\FactoryReaderInterface;
use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use App\Core\Mapper\MapperReadInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Factory implements FactoryReaderInterface
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }
    public function createRepository(): RepositoryReadInterface
    {
        return new CustomerRepository($this->client);//todo
    }

    public function createMapper(): MapperReadInterface
    {
        return new CustomerMapper();//todo
    }

}