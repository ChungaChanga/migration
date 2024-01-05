<?php

namespace App\Tests\Unit\Connector\Woocommerce;

use App\Connector\Woocommerce\Repository\CustomerRepository;
use App\Tests\TestBase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerRepositoryTest extends TestBase
{
    public function testNegativePageException()
    {
        self::bootKernel();
        $container = self::getContainer();
        $client = $container->get(HttpClientInterface::class);

        $repository = new CustomerRepository(
            $client,
            'test',
            'test',
            'test',
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('start page is must be more than 0 for Woocommerce api');
        $repository->createAwaitingPageIterator(-1);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('start page is must be more than 0 for Woocommerce api');
        $repository->createAwaitingPageIterator(0);
    }

}