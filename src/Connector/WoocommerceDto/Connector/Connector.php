<?php

namespace App\Connector\WoocommerceDto\Connector;

use App\Connector\WoocommerceDto\Mapper\Mapper;
use App\Connector\WoocommerceDto\Repository\Repository;
use Chungachanga\AbstractMigration\Connector\ConnectorReaderInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Connector implements ConnectorReaderInterface
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
            $this->repository = new Repository(
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
            $this->mapper = new Mapper();//todo
        }
        return $this->mapper;
    }

    public function getType(): string
    {
        return Customer::TYPE;//todo
    }

}