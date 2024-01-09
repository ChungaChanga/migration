<?php

namespace App\Connector\Magento\Factory;

use App\Connector\AbstractConnectorWriteFactory;
use App\Connector\ConnectorWriteType;
use App\Connector\Magento\Connector\BaseConnector;
use App\Event\EntitiesCreateAfterEvent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class ConnectorFactory extends AbstractConnectorWriteFactory
{
    public function __construct(
        protected HttpClientInterface $client,
        protected EventDispatcher $eventDispatcher,
        protected string $repositoryUrl,
        protected string $repositoryKey,
        protected string $repositorySecret,
    )
    {
    }
    public function createConnector(): ConnectorWriteType
    {
        return new BaseConnector(
            $this->createRepository(),
            $this->createMapper(),
            $this->eventDispatcher
        );
    }
}