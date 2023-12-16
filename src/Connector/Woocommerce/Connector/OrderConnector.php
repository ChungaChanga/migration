<?php

namespace App\Connector\Woocommerce\Connector;

use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderConnector
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
        return 'customer';//todo
    }
}