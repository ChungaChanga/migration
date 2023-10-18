<?php

namespace App\Connector\Woocommerce\Connector;

use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use App\Core\ConnectorAbstract\Connector\ConnectorReaderInterface;
use App\Core\ConnectorAbstract\Mapper\MapperReadInterface;
use App\Core\ConnectorAbstract\Mapper\MapperWriteInterface;
use App\Core\ConnectorAbstract\Repository\RepositoryReadInterface;
use App\Core\Entity\Customer;
use App\Core\Entity\EntityTypeInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerConnector implements ConnectorReaderInterface, EntityTypeInterface
{
    private ?RepositoryReadInterface $repository = null;
    private ?MapperReadInterface $mapper = null;
    public function __construct(
        private HttpClientInterface $client,
        private string $repositoryUrl,
        private string $repositoryKey,
        private string $repositorySecret,
    ) {
    }
    public function getRepository(): RepositoryReadInterface
    {
        if (null === $this->repository) {
            $this->repository = new CustomerRepository(
                $this->client,
                $this->repositoryUrl,
                $this->repositoryKey,
                $this->repositorySecret
            );
        }
        return $this->repository;
    }

    public function getMapper(): MapperReadInterface
    {
        if (null === $this->mapper) {
            $this->mapper = new CustomerMapper();//todo
        }
        return $this->mapper;
    }

    public function getType(): string
    {
        return Customer::TYPE;//todo
    }

}