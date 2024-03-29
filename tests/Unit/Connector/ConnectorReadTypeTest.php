<?php

namespace App\Tests\Unit\Connector;

use App\Connector\ConnectorReadType;
use App\Connector\Woocommerce\ConnectorBuilder\CustomerConnectorBuilder;
use App\Contract\Connector\Mapper\MapperReadInterface;
use App\Tests\TestBase;
use App\Contract\Connector\Repository\StorageReadInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ConnectorReadTypeTest extends TestBase
{
    private StorageReadInterface $repositoryMock;
    private MapperReadInterface $mapperMock;
    public function setUp(): void
    {
        $this->repositoryMock = $this->createMock(StorageReadInterface::class);
        $this->mapperMock = $this->createMock(MapperReadInterface::class);
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * @dataProvider negativeStartPageProvider
     * @return void
     */
    public function testNegativeStartPageException($startPage)
    {
        $connector = new ConnectorReadType($this->repositoryMock, $this->mapperMock);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Start page is must be more than 0');
        $connector->createIterator($startPage);
    }

    /**
     * @dataProvider createIteratorProvider
     * @return void
     */
    public function testCreateIterator($startPage)
    {
        $connector = new ConnectorReadType($this->repositoryMock, $this->mapperMock);
        $iterator = $connector->createIterator($startPage);

        $this->assertInstanceOf(\Iterator::class, $iterator);
    }

    public function negativeStartPageProvider()
    {
        return [
            [-1000000], [-1], [0]
        ];
    }

    public function createIteratorProvider()
    {
        return [
            [1],
            [10],
            [1000000]
        ];
    }
}