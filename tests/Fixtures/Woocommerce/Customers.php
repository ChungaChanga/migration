<?php

namespace App\Tests\Fixtures\Woocommerce;

use App\Tests\Fixtures\CustomersInterface;

class Customers implements CustomersInterface
{

    public function first(): array
    {
        return [
            'id' => 1,
            'email' => 'ritav@test.ru',
            'first_name' => 'Rita',
            'last_name' => 'Vrataski'
        ];
    }

    public function second(): array
    {
        //todo max valid length
       return [
            'id' => 2,
            'email'      => 'john11111111111111111111111111111111111119@test.ru',
            'first_name' => 'John1111111111111111111111111111111111111111111119',
            'last_name'  => 'Wick1111111111111111111111111111111111111111111119'
        ];
    }

    public function third(): array
    {
        return [
            'id' => 3,
            'email' => 'jwick@test.com',
            'first_name' => 'John',
            'last_name' => 'Wick'
        ];
    }

    public function fourth(): array
    {
        return [
            'id' => 4,
            'email' => 'tsawyer@test.ru',
            'first_name' => 'Tom',
            'last_name' => 'Sawyer'
        ];
    }

    public function fifth(): array
    {
        return [
            'id' => 5,
            'email' => 'jsnow@test.ru',
            'first_name' => 'Jon',
            'last_name' => 'Snow'
        ];
    }

    public function minId(): array
    {
        return [
            'id' => 1,//min valid id
            'email' => 'minid@test.ru',
            'first_name' => 'minidname',
            'last_name' => 'minidlastname'
        ];
    }

    public function maxId(): array
    {
        return [
            'id' => 9999999999999999,
            'email' => 'maxid@test.com',
            'first_name' => 'maxidname',
            'last_name' => 'maxidlastname'
        ];
    }

    public function withoutId(): array
    {
        return [
            'email' => 'withoutid@test.com',
            'first_name' => 'withoutidname',
            'last_name' => 'withoutidlastname'
        ];
    }

    public function withoutEmail(): array
    {
        return [
            'id' => 6,
            'first_name' => 'withoutemailname',
            'last_name' => 'withoutemaillastname'
        ];
    }

    public function maxIdOver(): array
    {
        return [
            'id' => PHP_INT_MAX * 2,
            'email' => 'maxidover@test.com',
            'first_name' => 'maxidovername',
            'last_name' => 'maxidoverlastname'
        ];
    }

    public function minIdLess(): array
    {
        return [
            'id' => 0,
            'email' => 'minidless@test.com',
            'first_name' => 'minidlessname',
            'last_name' => 'minidlesslastname'
        ];
    }

    public function double(): array
    {
        return [
            $this->first(),
            $this->first(),
        ];
    }

}