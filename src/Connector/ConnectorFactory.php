<?php

namespace App\Connector;


use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Mapper\OrderMapper;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use App\Connector\Woocommerce\Repository\OrderRepository;
use App\Migration\MigrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ConnectorFactory
{
    public function __construct(
        private MigrationType $entityType,
        private HttpClientInterface $client,
        private EntityManagerInterface $entityManager,
        private ContainerBagInterface $params
    )
    {
    }
    public function createSourceConnector(): ConnectorReadType
    {
        if (MigrationType::Customers === $this->entityType) {
            $repository = new CustomerRepository(
                $this->client,
                'test',
                'test',
                'test',//todo get from config
            );
            $mapper = new CustomerMapper();
        } elseif (MigrationType::Orders === $this->entityType) {
            $repository = new OrderRepository(
                $this->client,
                'test',
                'test',
                'test',//todo get from config
            );
            $mapper = new OrderMapper($this->entityManager);
        } else {
            throw new \DomainException('Unexpected entity type ' . $this->entityType->name);
        }

        return new ConnectorReadType($repository, $mapper);
    }

    public function createDestinationConnector(): ConnectorWriteType
    {
        if (MigrationType::Customers === $this->entityType) {
            $repository = new \App\Connector\Magento\Repository\CustomerRepository(
                $this->client,
                'test',
                'test',
                'test',//todo get from config
            );
            $mapper = new \App\Connector\Magento\Mapper\CustomerMapper();
        } elseif (MigrationType::Orders === $this->entityType) {
            $repository = new \App\Connector\Magento\Repository\OrderRepository(
                $this->client,
                'test',
                'test',
                'test',//todo get from config
            );
            $mapper = new \App\Connector\Magento\Mapper\OrderMapper();
        } else {
            throw new \DomainException('Unexpected entity type ' . $this->entityType->name);
        }

        return new ConnectorWriteType($repository, $this->entityManager, $mapper);
    }
}