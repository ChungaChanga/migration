<?php

namespace App\Tests\Functional;

use App\Connector\Woocommerce\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerRepositoryTest extends KernelTestCase
{
    public function testFetchPage()
    {
        self::bootKernel();
        $container = self::getContainer();
        $client = $container->get(HttpClientInterface::class);

        $repository = new CustomerRepository(
            $client,
            $_ENV['WOOCOMMERCE_API_URL_CUSTOMERS'],
            $_ENV['WOOCOMMERCE_API_KEY'],
            $_ENV['WOOCOMMERCE_API_SECRET']
        );

        $customers = $repository->fetchPage(1, 10);

        $this->assertCount(10, $customers);//todo fix woo api
    }
}