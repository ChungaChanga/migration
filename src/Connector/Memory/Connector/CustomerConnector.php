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
    private ?RepositoryInterface $repository = null;
    private ?MapperInterface $mapper = null;
    public function getRepository(): RepositoryInterface
    {
        if (null === $this->repository) {
            $this->repository = new CustomerRepository();//todo
        }
        return $this->repository;
    }

    public function getMapper(): MapperInterface
    {
        if (null === $this->mapper) {
            $this->mapper = new CustomerMapper();//todo
        }
        return $this->mapper;
    }

    public function getType(): string
    {
        return Customer::TYPE;
    }
}