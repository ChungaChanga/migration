<?php

namespace App\Tests\Integration\Connector\Magento\Repository;

use App\Connector\Magento\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerRepositoryTest extends KernelTestCase
{
     function  testCreate()
     {
         self::bootKernel();
         $container = self::getContainer();
         $client = $container->get(HttpClientInterface::class);

         $repository = new CustomerRepository(
             $client,
             $_ENV['MAGENTO_API_URL_CUSTOMERS']
         );

         $result = $repository->create([
             [
                "email" => "test5@mail.ru",
                "firstname" => "petya",
                "lastname" => "bar"
             ]
         ]);

         $this->assertEquals('ok', $result);
     }
}