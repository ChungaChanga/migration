<?php

namespace App\Tests\Fixtures\Magento;

use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\OrdersInterface;
use App\Tests\Fixtures\ProductsInterface;

class Orders implements OrdersInterface
{
    private CustomersInterface $customers;
    private ProductsInterface $products;
    public function __construct()
    {
        $this->customers = new Customers();
        $this->products = new Products();
    }


    public function first(): array
    {
        $customer = $this->customers->first();
        return [
            //fixme grand_total = current currency grand total
            //
            //base_grand_total = store base currency grand total
            //woo has CAD and USD !!!
            'id' => 1,
            'base_grand_total' => 1,
            'grand_total' => 1,
            'customer_email' => $customer['email'],
            'items' => [
                [
                    'sku' => $this->products->first()['sku']
                ],
            ],
        ];
    }

    public function second(): array
    {
        $customer = $this->customers->second();
        return [
            'id' => 2,
            'base_grand_total' => 1000,
            'grand_total' => 1000,
            'customer_email' => $customer['email'],
            'items' => [
                [
                    'sku' => $this->products->second()['sku']
                ],
            ],
        ];
    }

    public function third(): array
    {
        $customer = $this->customers->third();
        return [
            'id' => 3,
            'base_grand_total' => 99999999,
            'grand_total' => 99999999,
            'customer_email' => $customer['email'],
            'items' => [
                [
                    'sku' => $this->products->third()['sku']
                ],
            ],
        ];
    }
}