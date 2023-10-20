<?php

namespace App\Connector\Magento\Connector;

use App\Connector\Magento\Mapper\CustomerMapper;
use App\Connector\Magento\Repository\CustomerRepository;
use Chungachanga\AbstractMigration\Connector\ConnectorWriterInterface;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;

class CustomerConnector implements ConnectorWriterInterface
{
    private ?RepositoryWriteInterface $repository = null;
    private ?MapperWriteInterface $mapper = null;
    public function getRepository(): RepositoryWriteInterface
    {
        if (null === $this->repository) {
            $this->repository = new CustomerRepositor();//todo
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