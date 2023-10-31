<?php

namespace App\Tests\Functional;

use App\Entity\Customer;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomerMigrationTest extends KernelTestCase
{
    public function testWoocommerceToMagentoMigrationByDto()
    {

    }

    private function createWoocommerceDto(): Customer
    {
        $customer = [
            'id' => 1234,
            'firstname' => 'Ivan Ivanov',
            'orders' => [
                [
                    'id' => 101,
                    'total' => 10000,
                    'products' => [
                        [
                            'id' => 123,
                            'title' => 'Product 1'
                        ]
                    ]
                ],
            ]
        ];
        $customer = new Customer();
        $order1 = new Order();
        $order2 = new Order();
        $order1->setSourceId(101);
        $order2->setSourceId(1002);
    }

    public function customersProvider()
    {
        $woocommerceCustomer1 = [
            'id' => 1234,
            'firstname' => 'Ivan Ivanov',
            'orders' => [
                [
                    'id' => 101,
                    'total' => 10000,
                    'products' => [
                        [
                            'id' => 123,
                            'title' => 'Product 1'
                        ]
                    ]
                ],
            ]
        ];
        $magentoCustomer1 = [

        ];
    }
}