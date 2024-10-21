<?php

namespace App\Connector;


use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Connector\Woocommerce\Mapper\OrderMapper;
use App\Connector\Woocommerce\Storage\CustomerStorage;
use App\Connector\Woocommerce\Storage\OrderStorage;
use App\Migration\MigrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

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
            $storage = new CustomerStorage(
                $this->client,
//                env('WOOCOMMERCE_API_URL_CUSTOMERS'),
//                env('WOOCOMMERCE_API_KEY'),
//                env('WOOCOMMERCE_API_SECRET'),
                'https://dl.loc/wc-api/v3/customers',
                'ck_4ff7fa13fb22c7de2b2ec11b1730fd4e742e3e50',
                'cs_fa1488c47696ab78b1bce373358ee653e9e510dd'

            );
            $mapper = new CustomerMapper();
        } elseif (MigrationType::Orders === $this->entityType) {
            $storage = new OrderStorage(
                $this->client,
                'test',
                'test',
                'test',//todo get from config
            );
            $mapper = new OrderMapper($this->entityManager);
        } else {
            throw new \DomainException('Unexpected entity type ' . $this->entityType->name);
        }

        return new ConnectorReadType($storage, $mapper);
    }

    public function createDestinationConnector(): ConnectorWriteType
    {
        if (MigrationType::Customers === $this->entityType) {
            $storage = new Magento\Storage\CustomerStorage(
                $this->client,
                'test',
            );
            $mapper = new Magento\Mapper\CustomerMapper();
        } elseif (MigrationType::Orders === $this->entityType) {
            $storage = new Magento\Storage\OrderStorage(
                $this->client,
                'test',
            );
            $mapper = new Magento\Mapper\OrderMapper();
        } else {
            throw new \DomainException('Unexpected entity type ' . $this->entityType->name);
        }

        return new ConnectorWriteType($storage, $this->entityManager, $mapper);
    }
}