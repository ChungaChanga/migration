<?php

namespace App\Tests\Fixtures\Woocommerce;

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
            'id' => 1,
            'total' => 1,
            'customer_id' => $customer['id'],
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
            'total' => 1000,
            'customer_id' => $customer['id'],
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
            'total' => 99999999,
            'customer_id' => $customer['id'],
            'items' => [
                [
                    'sku' => $this->products->third()['sku']
                ],
            ],
        ];
    }
}