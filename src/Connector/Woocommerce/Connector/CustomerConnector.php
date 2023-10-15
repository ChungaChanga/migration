<?php

namespace App\Connector\Woocommerce\Connector;

use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use App\Core\ConnectorInterface\Connector\ConnectorReaderInterface;
use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use App\Core\Entity\Customer;
use App\Core\Entity\EntityTypeInterface;
use App\Core\Mapper\MapperReadInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerConnector implements ConnectorReaderInterface, EntityTypeInterface
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

    public function getType(): string
    {
        return Customer::TYPE;//todo
    }

}