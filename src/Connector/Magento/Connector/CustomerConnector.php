<?php

namespace App\Connector\Magento\Connector;

use App\Connector\Magento\Mapper\CustomerMapper;
use App\Connector\Magento\Repository\CustomerRepository;
use Chungachanga\AbstractMigration\Connector\ConnectorWriterInterface;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerConnector implements ConnectorWriterInterface
{
    private ?RepositoryWriteInterface $repository = null;
    private ?MapperWriteInterface $mapper = null;
    public function __construct(
        private HttpClientInterface $client,
        private string $repositoryUrl,
    ) {
    }

    public function create($entities)//todo interface and type
    {

    }

    public function createOne($entity)//todo interface and type
    {

    }
    public function getRepository(): RepositoryWriteInterface
    {
        if (null === $this->repository) {
            $this->repository = new CustomerRepository(
                $this->client,
                $this->repositoryUrl,
            );//todo
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
        return 'customer';
    }
}