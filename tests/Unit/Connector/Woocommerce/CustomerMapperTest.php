<?php

namespace App\Tests\Unit\Connector\Woocommerce;

use App\Connector\Woocommerce\Mapper\CustomerMapper;
use App\Entity\Customer;
use App\Exception\InvalidStateException;
use App\Tests\TestBase;

class CustomerMapperTest extends TestBase
{

    public function testCreateCustomer()
    {
        $customerState = [
            'id' => 1,
            'email' => 'ritav@test.ru',
            'first_name' => 'Rita',
            'last_name' => 'Vrataski'
        ];

        $mapper = new CustomerMapper();
        $customer = $mapper->fromState($customerState);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals($customerState['email'], $customer->getEmail());
        $this->assertEquals($customerState['first_name'], $customer->getFirstName());
        $this->assertEquals($customerState['last_name'], $customer->getLastName());
    }

    public function testValidateEmail()
    {
        $this->expectException(InvalidStateException::class);
        $this->expectExceptionMessage('email is required');

        $customerState = [
            'id' => 1,
            'first_name' => 'Rita',
            'last_name' => 'Vrataski'
        ];
        $mapper = new CustomerMapper();
        $mapper->validateState($customerState);

    }

    public function testValidateId()
    {
        $this->expectException(InvalidStateException::class);
        $this->expectExceptionMessage('id is required');

        $customerState = [
            'email' => 'ritav@test.ru',
            'first_name' => 'Rita',
            'last_name' => 'Vrataski'
        ];
        $mapper = new CustomerMapper();
        $mapper->validateState($customerState);
    }

    public function testValidateFirstName()
    {
        $this->expectException(InvalidStateException::class);
        $this->expectExceptionMessage('first_name is required');

        $customerState = [
            'id' => 1,
            'email' => 'ritav@test.ru',
            'last_name' => 'Vrataski'
        ];
        $mapper = new CustomerMapper();
        $mapper->validateState($customerState);

    }

    public function testValidateLastName()
    {
        $this->expectException(InvalidStateException::class);
        $this->expectExceptionMessage('last_name is required');

        $customerState = [
            'id' => 1,
            'email' => 'ritav@test.ru',
            'first_name' => 'Rita',
        ];
        $mapper = new CustomerMapper();
        $mapper->validateState($customerState);
    }

}