<?php

namespace App\Tests\Fixtures\Magento;

use App\Tests\Fixtures\CustomersInterface;

class Customers implements CustomersInterface
{

    public function first(): array
    {
        return [
            'id' => 1,
            'email' => 'ritav@test.ru',
            'firstname' => 'Rita',
            'lastname' => 'Vrataski'
        ];
    }

    public function second(): array
    {
        //todo max valid length
       return [
            'id' => 2,
            'email'      => 'john11111111111111111111111111111111111119@test.ru',
            'firstname' => 'John1111111111111111111111111111111111111111111119',
            'lastname'  => 'Wick1111111111111111111111111111111111111111111119'
        ];
    }

    public function third(): array
    {
        return [
            'id' => 3,
            'email' => 'jwick@test.com',
            'firstname' => 'John',
            'lastname' => 'Wick'
        ];
    }

    public function minId(): array
    {
        return [
            'id' => 1,//min valid id
            'email' => 'minid@test.ru',
            'firstname' => 'minidname',
            'lastname' => 'minidlastname'
        ];
    }

    public function maxId(): array
    {
        return [
            'id' => 9999999999999999,
            'email' => 'maxid@test.com',
            'firstname' => 'maxidname',
            'lastname' => 'maxidlastname'
        ];
    }

    public function withoutId(): array
    {
        return [
            'email' => 'withoutid@test.com',
            'firstname' => 'withoutidname',
            'lastname' => 'withoutidlastname'
        ];
    }

    public function withoutEmail(): array
    {
        return [
            'id' => 6,
            'firstname' => 'withoutemailname',
            'lastname' => 'withoutemaillastname'
        ];
    }

    public function maxIdOver(): array
    {
        return [
            'id' => PHP_INT_MAX * 2,
            'email' => 'maxidover@test.com',
            'firstname' => 'maxidovername',
            'lastname' => 'maxidoverlastname'
        ];
    }

    public function minIdLess(): array
    {
        return [
            'id' => 0,
            'email' => 'minidless@test.com',
            'firstname' => 'minidlessname',
            'lastname' => 'minidlesslastname'
        ];
    }
}