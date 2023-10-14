<?php

namespace App\Tests\Connector\Woocommerce\Repository;

use App\Connector\Woocommerce\Repository\CustomerRepository;
use App\Tests\AppBase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerRepositoryTest extends AppBase
{
    public function testFetch()
    {
        self::bootKernel();
        $container = self::getContainer();
        $client = $container->get(HttpClientInterface::class);

        $repository = new CustomerRepository($client);
        $customers = $repository->fetch(0, 10);

        $this->assertCount(9, $customers);//todo fix woo api
    }

    public function testFetchPage()
    {
        self::bootKernel();
        $container = self::getContainer();
        $client = $container->get(HttpClientInterface::class);

        $repository = new CustomerRepository($client);
        $customers = $repository->fetchPage(0, 10);

        $this->assertCount(9, $customers);//todo fix woo api
    }
}