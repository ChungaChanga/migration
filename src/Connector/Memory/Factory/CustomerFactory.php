<?php

namespace App\Connector\Memory\Factory;

use App\Connector\Memory\Mapper\CustomerMapper;
use App\Connector\Memory\Repository\CustomerRepository;
use App\Core\ConnectorFactory\FactoryInterface;
use App\Core\ConnectorInterface\Repository\RepositoryInterface;
use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use App\Core\Entity\Customer;
use App\Core\Mapper\MapperInterface;
use App\Core\Mapper\MapperReadInterface;

class CustomerFactory implements FactoryInterface
{
    public function createRepository(): RepositoryInterface
    {
        return new CustomerRepository();//todo
    }

    public function createMapper(): MapperInterface
    {
        return new CustomerMapper();//todo
    }
}