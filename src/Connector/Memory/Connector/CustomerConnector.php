<?php

namespace App\Connector\Memory\Connector;

use App\Connector\Memory\Mapper\CustomerMapper;
use App\Connector\Memory\Repository\CustomerRepository;
use App\Core\ConnectorInterface\Connector\ConnectorInterface;
use App\Core\ConnectorInterface\Repository\RepositoryInterface;
use App\Core\Entity\Customer;
use App\Core\Entity\EntityTypeInterface;
use App\Core\Mapper\MapperInterface;

class CustomerConnector implements ConnectorInterface, EntityTypeInterface
{
    public function createRepository(): RepositoryInterface
    {
        return new CustomerRepository();//todo
    }

    public function createMapper(): MapperInterface
    {
        return new CustomerMapper();//todo
    }

    public function getType(): string
    {
        return Customer::TYPE;
    }
}