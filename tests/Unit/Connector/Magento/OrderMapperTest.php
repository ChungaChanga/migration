<?php

namespace App\Tests\Unit\Connector\Magento;

use App\Connector\Magento\Mapper\OrderMapper;
use App\Entity\Customer;
use App\Entity\Order;
use App\Exception\InvalidStateException;
use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\Magento\Orders;
use App\Tests\Fixtures\OrdersInterface;
use App\Tests\Fixtures\Woocommerce\Customers;
use App\Tests\TestBase;

class OrderMapperTest extends TestBase
{

    private OrdersInterface $fixtures;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->fixtures = new Orders();
        parent::__construct($name, $data, $dataName);
    }
    public function testGetState()
    {
        $orderFixtureState =  $this->fixtures->first();

        $order = new Order();
        $order->setTotal($orderFixtureState['base_grand_total']);

        $customer = new Customer();
        $customer->setEmail($orderFixtureState['customer_email']);
        $order->setCustomer($customer);

        $orderState = (new OrderMapper())->getState($order);

        $this->assertEquals($orderFixtureState['base_grand_total'], $orderState['base_grand_total']);
        $this->assertEquals($orderFixtureState['customer_email'], $orderState['customer_email']);
    }
}