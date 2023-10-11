<?php

namespace App\Tests\Repository;

use App\Repository\CustomerWoocommerceApiRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerWoocommerceApiRepositoryTest extends KernelTestCase
{
    public function testGetSomeCustomers()
    {
        self::bootKernel();
        $container = self::getContainer();
        $client = $container->get(HttpClientInterface::class);

        $repository = new CustomerWoocommerceApiRepository($client);
        $customers = $repository->fetch(0, 10);

        $this->assertCount(9, $customers);//todo fix woo api
    }
}