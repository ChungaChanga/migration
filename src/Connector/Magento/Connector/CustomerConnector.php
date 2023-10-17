<?php

namespace App\Connector\Magento\Connector;

use App\Connector\Magento\Mapper\CustomerMapper;
use App\Connector\Magento\Repository\CustomerRepository;
use App\Core\ConnectorAbstract\Connector\ConnectorWriterInterface;
use App\Core\ConnectorAbstract\Mapper\MapperWriteInterface;
use App\Core\ConnectorAbstract\Repository\RepositoryWriteInterface;
use App\Core\Entity\Customer;
use App\Core\Entity\EntityTypeInterface;

class CustomerConnector implements ConnectorWriterInterface, EntityTypeInterface
{
    private ?RepositoryWriteInterface $repository = null;
    private ?MapperWriteInterface $mapper = null;
    public function getRepository(): RepositoryWriteInterface
    {
        if (null === $this->repository) {
            $this->repository = new CustomerRepository();//todo
        }
        return $this->repository;
    }

    public function getMapper(): MapperWriteInterface
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