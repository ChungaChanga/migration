<?php

namespace App\Tests\Unit\Connector\Woocommerce;

use App\Connector\Woocommerce\ConnectorBuilder\CustomerConnectorBuilder;
use App\Connector\Woocommerce\Repository\CustomerRepository;
use App\Tests\TestBase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerConnectorFactoryTest extends TestBase
{
    /**
     * @dataProvider negativeStartPageProvider
     * @return void
     */
    public function testNegativeStartPageException($startPage)
    {
        $client = $this->createMock(HttpClientInterface::class);

        $repository = new CustomerConnectorBuilder(
            $client,
            'test',
            'test',
            'test',
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('start page is must be more than 0 for Woocommerce api');
        $repository->createIterator($startPage);
    }

    /**
     * @dataProvider createIteratorProvider
     * @return void
     */
    public function testCreateIterator($startPage)
    {
        $this->markTestSkipped();
        $client = $this->createMock(HttpClientInterface::class);

        $repository = new CustomerConnectorBuilder(
            $client,
            'test',
            'test',
            'test',
        );

        $repository->createIterator($startPage);
    }

    public function negativeStartPageProvider()
    {
        return [
            [-1000000], [-1], [0]
        ];
    }
    //todo
    public function createIteratorProvider()
    {
        return [
            [
                1,
                10
            ],
            [1000000]
        ];
    }
}