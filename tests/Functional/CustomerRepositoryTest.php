<?php

namespace App\Tests\Functional;

use App\Connector\Woocommerce\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerRepositoryTest extends KernelTestCase
{
    public function testFetch()
    {
        self::bootKernel();
        $container = self::getContainer();
        $client = $container->get(HttpClientInterface::class);

        $repository = new CustomerRepository($client);
        $customers = $repository->fetch(1, 10);

        $this->assertCount(9, $customers);//todo fix woo api
    }

    public function testFetchPage()
    {
        self::bootKernel();
        $container = self::getContainer();
        $client = $container->get(HttpClientInterface::class);

        $repository = new CustomerRepository($client);
        $customers = $repository->fetchPage(1, 10);

        $this->assertCount(9, $customers);//todo fix woo api
    }
}