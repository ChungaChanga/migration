<?php declare(strict_types=1);

namespace App\Connector\Magento\ConnectorBuilder;

use App\Connector\ConnectorWriteType;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryWriteInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class ConnectorBuilder
{
    protected ConnectorWriteType $connector;

    public function reset(): void
    {
        $this->connector = new ConnectorWriteType();
    }

    public function getConnector(): ConnectorWriteType
    {
        return $this->connector;
    }
    public function createEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->getConnector()->setEventDispatcher($eventDispatcher);
    }

    abstract public function createRepository(
        HttpClientInterface $client,
        string $url,
        string $key,
        string $secret,
    ): void;
    abstract public function createMapper(): void;
}