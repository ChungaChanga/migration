<?php declare(strict_types=1);

namespace App\Connector\Woocommerce\ConnectorBuilder;

use App\Connector\AbstractConnectorReadBuilder;
use App\Connector\ConnectorReadType;
use App\Iterator\ConnectorIterator;
use Chungachanga\AbstractMigration\Connector\ConnectorFactoryReadInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class ConnectorBuilder
{
    protected ConnectorReadType $connector;

    public function reset(): void
    {
        $this->connector = new ConnectorReadType();
    }

    public function getConnector(): ConnectorReadType
    {
        return $this->connector;
    }
    public function createIterator(
        int $startPage,
        int $pageSize = 10,
        bool $isNeedWaitingFullPage = false,
        bool $isAllowPartialResult = true,
        int $delaySeconds = 0
    ): void
    {
        if ($startPage < 1) {
            throw new \InvalidArgumentException('start page is must be more than 0 for Woocommerce api');
        }
        $this->connector->setIterator(
            new ConnectorIterator(
                $this->connector->getRepository(),
                $this->connector->getMapper(),
                $startPage,
                $pageSize,
                $isNeedWaitingFullPage,
                $isAllowPartialResult,
                $delaySeconds
            )
        );
    }
    abstract public function createRepository(
        HttpClientInterface $client,
        string $url,
        string $key,
        string $secret,
    ): void;
    abstract public function createMapper(): void;
}