<?php

namespace App\Tests\Unit\Connector\Woocommerce;

use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Entity\Customer;
use App\Exception\InvalidStateException;
use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\Woocommerce\Customers;
use App\Tests\TestBase;

class CustomerMapperTest extends TestBase
{

    private CustomersInterface $fixturesWoocommerce;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->fixturesWoocommerce = new Customers();
        parent::__construct($name, $data, $dataName);
    }
    public function testCreateCustomer()
    {
        $customerState =  $this->fixturesWoocommerce->first();
        $customer = (new CustomerMapper())->fromState($customerState);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals($customerState['email'], $customer->getEmail());
        $this->assertEquals($customerState['first_name'], $customer->getFirstName());
        $this->assertEquals($customerState['last_name'], $customer->getLastName());
    }

    public function testValidateEmail()
    {
        $this->expectException(InvalidStateException::class);
        $this->expectExceptionMessage('property email is required');

        $customerState =  $this->fixturesWoocommerce->withoutEmail();
        (new CustomerMapper())->fromState($customerState);
    }

    public function testValidateId()
    {
        $this->expectException(InvalidStateException::class);
        $this->expectExceptionMessage('property id is required');

        $customerState =  $this->fixturesWoocommerce->withoutId();
        (new CustomerMapper())->fromState($customerState);
    }
}