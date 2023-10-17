<?php

namespace App\Connector\Woocommerce\Connector;

use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use App\Core\ConnectorAbstract\Connector\ConnectorReaderInterface;
use App\Core\ConnectorAbstract\Mapper\MapperReadInterface;
use App\Core\ConnectorAbstract\Repository\RepositoryReadInterface;
use App\Core\Entity\Customer;
use App\Core\Entity\EntityTypeInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerConnector implements ConnectorReaderInterface, EntityTypeInterface
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }
    public function getRepository(): RepositoryReadInterface
    {
        return new CustomerRepository($this->client);//todo
    }

    public function getMapper(): MapperReadInterface
    {
        return new CustomerMapper();//todo
    }

    public function getType(): string
    {
        return Customer::TYPE;//todo
    }

}