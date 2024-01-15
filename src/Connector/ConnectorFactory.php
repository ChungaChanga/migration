<?php

namespace App\Connector;

use App\Connector\Magento\ConnectorBuilder\CustomerConnectorBuilder as MagentoCustomerConnectorBuilder;
use App\Connector\Magento\ConnectorBuilder\OrderConnectorBuilder as MagentoOrderConnectorBuilder;
use App\Connector\Woocommerce\ConnectorBuilder\CustomerConnectorBuilder as WooCustomerConnectorBuilder;
use App\Connector\Woocommerce\ConnectorBuilder\OrderConnectorBuilder as WooOrderConnectorBuilder;
use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Mapper\OrderMapper;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use App\Connector\Woocommerce\Repository\OrderRepository;
use App\Migration\MigrationType;
use App\Contract\Connector\Connector\ConnectorBuilderReadInterface;
use App\Contract\Connector\Connector\ConnectorBuilderWriteInterface;
use App\Contract\Connector\Connector\ConnectorReadInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ConnectorFactory
{
    public function __construct(
        private MigrationType $entityType,
        private HttpClientInterface $client,
        private EventDispatcherInterface $eventDispatcher,
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
            $connector = new ConnectorReadType($repository, $mapper);
        } elseif (MigrationType::Orders === $this->entityType) {
            $repository = new OrderRepository(
                $this->client,
                'test',
                'test',
                'test',//todo get from config
            );
            $mapper = new OrderMapper();
            $connector = new ConnectorReadType($repository, $mapper);
        } else {
            throw new \DomainException('Unexpected entity type ' . $this->entityType->name);
        }
        return $connector;
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
            $connector = new ConnectorWriteType($repository, $this->eventDispatcher, $mapper);
        } elseif (MigrationType::Orders === $this->entityType) {
            $repository = new \App\Connector\Magento\Repository\OrderRepository(
                $this->client,
                'test',
                'test',
                'test',//todo get from config
            );
            $mapper = new \App\Connector\Magento\Mapper\OrderMapper();
            $connector = new ConnectorWriteType($repository, $this->eventDispatcher, $mapper);
        } else {
            throw new \DomainException('Unexpected entity type ' . $this->entityType->name);
        }
        return $connector;
    }
}